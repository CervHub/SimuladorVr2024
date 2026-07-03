<?php

require('conexion.php');
require('logger.php');

$endpoint = 'getLogin';
$query_params_login = [
    ':dni' => $_POST['dni'] ?? null,
    ':id_company' => $_POST['id_company'] ?? null,
];

apiUnityLog($endpoint, 'REQUEST', 'Ingreso', $_POST);

try {
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

    $query = "SELECT workshops.name as taller, steps.name, steps.duration
              FROM steps
              INNER JOIN workshops ON steps.workshop_id = workshops.id
              ORDER BY steps.created_at";

    $stmt = $db->prepare($query);
    $stmt->execute();

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $default_steps = [];
    foreach ($results as $row) {
        $taller = strtoupper($row['taller']);
        if (!isset($default_steps[$taller])) {
            $default_steps[$taller] = ['pasos' => []];
        }
        $default_steps[$taller]['pasos'][] = [
            'name' => $row['name'],
            'duration' => $row['duration'],
        ];
    }

    $stmt1 = $db->prepare($queryInduction);
    $stmt1->execute($query_params_login);

    $db->exec('RESET TIME ZONE');

    header('Content-Type: application/json');

    if ($stmt1->rowCount() > 0) {
        $inductions = $stmt1->fetchAll(PDO::FETCH_ASSOC);

        foreach ($inductions as &$induction) {
            $taller = strtoupper($induction['taller']);
            if (isset($default_steps[$taller])) {
                $induction['pasos'] = $default_steps[$taller]['pasos'];
            } else {
                $induction['pasos'] = [];
            }
        }

        $responseData = [
            'dni' => $query_params_login[':dni'],
            'inducciones' => $inductions,
        ];

        apiUnityLog($endpoint, 'RESPONSE', '200 OK', $responseData);
        echo json_encode($responseData);
    } else {
        $responseData = ['error' => 'No se encontraron datos.'];
        http_response_code(202);
        apiUnityLog($endpoint, 'RESPONSE', '202 Sin datos', $responseData);
        echo json_encode($responseData);
    }
} catch (PDOException $ex) {
    header('Content-Type: application/json');
    $responseData = ['error' => 'Error en la consulta: ' . $ex->getMessage()];
    apiUnityLog($endpoint, 'ERROR', 'PDOException', $responseData);
    echo json_encode($responseData);
} catch (Exception $ex) {
    header('Content-Type: application/json');
    $responseData = ['error' => 'Error general: ' . $ex->getMessage()];
    apiUnityLog($endpoint, 'ERROR', 'Exception', $responseData);
    echo json_encode($responseData);
}
