<?php

require("conexion.php");

$query_params_login = array(
    ':dni' => $_POST['dni'],
    ':id_company' => $_POST['id_company'],
);

// Establecer la zona horaria de la sesión en Perú
$db->exec("SET TIME ZONE 'America/Lima'");

$queryInduction = "SELECT
    inductions.id as induction_id,
    w.id as id_workshop,
    induction_workers.id as cabecera_id,
    (induction_workers.num_report + 1) as intento,
    inductions.intentos,
    inductions.date_start || ' ' || inductions.time_start as fecha_inicio,
    inductions.date_end || ' ' || inductions.time_end as fecha_fin,
    wc.alias as taller,
    workers.nombre as nombre,
    workers.apellido as apellido,
    workers.position as cargo,
    workers.celular as celular,
    s.name as nombre_servicio,
	s.id as id_service
FROM induction_workers
JOIN inductions ON induction_workers.id_induction = inductions.id
JOIN workshops AS w ON inductions.id_workshop = w.id
JOIN workshop_companies AS wc ON wc.id_workshop = w.id
JOIN workers ON induction_workers.id_worker = workers.id
JOIN services as s ON s.id = workers.id_service
WHERE inductions.intentos >= (induction_workers.num_report + 1)
    AND induction_workers.id_worker in (SELECT id FROM workers WHERE code_worker LIKE '%-' || :dni AND id_company = :id_company)
    AND wc.id_company = :id_company
    AND inductions.status = '1'
    AND (to_timestamp(inductions.date_end || ' ' || inductions.time_end, 'YYYY-MM-DD HH24:MI:SS')) >= CURRENT_TIMESTAMP
    AND (to_timestamp(inductions.date_start || ' ' || inductions.time_start, 'YYYY-MM-DD HH24:MI:SS')) <= CURRENT_TIMESTAMP
;";

try {
    $stmt1 = $db->prepare($queryInduction);
    $stmt1->execute($query_params_login);

    // Restablecer la zona horaria de la sesión a su valor predeterminado si es necesario
    $db->exec("RESET TIME ZONE");

    if ($stmt1->rowCount() > 0) {
        $responseData = [
            'dni' => $query_params_login[':dni'],
            'inducciones' => $stmt1->fetchAll(PDO::FETCH_ASSOC),
        ];

        // Establecer encabezados HTTP y enviar respuesta JSON
        header('Content-Type: application/json');
        echo json_encode($responseData);
    } else {
        // No se encontraron resultados, enviar una respuesta apropiada
        header('Content-Type: application/json');
        http_response_code(404); // Código 404 para "No encontrado".
        echo json_encode(array('error' => 'No se encontraron datos.'));
    }
} catch (PDOException $ex) {
    // Manejar errores PDO
    header('Content-Type: application/json');
    echo json_encode(array('error' => 'Error en la consulta: ' . $ex->getMessage()));
} catch (Exception $ex) {
    // Manejar otros errores generales
    header('Content-Type: application/json');
    echo json_encode(array('error' => 'Error general: ' . $ex->getMessage()));
}
?>
