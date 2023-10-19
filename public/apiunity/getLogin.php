<?php

require("conexion.php");

// Definir los parámetros en un array

$query_params_login = array(
    ':dni' => $_POST['dni'],
    ':id_company' => $_POST['id_company'],
);

$queryLogin = "
SELECT *
FROM workers
WHERE code_worker LIKE '%-' || :dni
  AND id_company = :id_company
LIMIT 1;
";

$queryInduction = "
SELECT
    inductions.id as induction_id,
    w.id as id_workshop,
    induction_workers.id as induction_workers,
    inductions.date_start,
    inductions.date_end,
    inductions.time_start,
    inductions.time_end,
    wc.alias as name
FROM
    induction_workers
JOIN
    inductions ON induction_workers.id_induction = inductions.id
JOIN
    workshops AS w ON inductions.id_workshop = w.id
JOIN
	workshop_companies AS wc 
	ON wc.id_workshop = w.id
WHERE
    induction_workers.id_worker = :id_worker
    AND wc.id_company = :id_company
    AND inductions.date_end >= CURRENT_DATE
    AND inductions.date_start <= CURRENT_DATE
;
";

// AND inductions.time_end >= CURRENT_TIME
// AND inductions.time_start <= CURRENT_TIME

try {
    $stmt = $db->prepare($queryLogin);
    // Bind de los parámetros utilizando el array
    $stmt->execute($query_params_login);

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (!empty($results)) {
        $id_user = $results[0]['id'];
        
        $query_params_induction = array(
            ':id_worker' => $id_user,
            ':id_company' => $query_params_login['id_company'];
        );
        
        $stmt1 = $db->prepare($queryInduction);
        // Bind de los parámetros utilizando el array
        $stmt1->execute($query_params_induction);

        $responseData = [
            'dni' => $_POST['dni'], // Debes reemplazar esto con el valor de $dni si lo deseas
            'id_worker' => $id_user, // Usamos el valor obtenido de la consulta anterior
            'worker' => $results[0]['code_worker'], // Usamos el valor obtenido de la consulta anterior
            'inducciones' => $stmt1->fetchAll(PDO::FETCH_ASSOC), // Obtenemos las inducciones de la consulta $stmt1
        ];

        $jsonResponse = json_encode($responseData);
        echo $jsonResponse;
    } else {
        echo json_encode(array('error' => 'No se encontraron resultados para el usuario'));
    }
} catch (PDOException $ex) {
    echo json_encode(array('error' => 'Error en la consulta: ' . $ex->getMessage()));
}
?>
