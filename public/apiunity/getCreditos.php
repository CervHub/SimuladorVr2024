<?php

require('conexion.php');
require('logger.php');

$endpoint = 'getCreditos';
$id_company = $_POST['id_company'] ?? null;

apiUnityLog($endpoint, 'REQUEST', 'Ingreso', $_POST);

header('Content-Type: application/json');

try {
    if ($id_company === null || $id_company === '') {
        http_response_code(422);
        $responseData = ['status' => false, 'error' => 'id_company es requerido.'];
        apiUnityLog($endpoint, 'RESPONSE', '422', $responseData);
        echo json_encode($responseData);
        exit;
    }

    $stmt = $db->prepare('SELECT id, name, creditos, creditos_originales FROM companies WHERE id = :id_company LIMIT 1');
    $stmt->execute([':id_company' => $id_company]);
    $company = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$company) {
        http_response_code(404);
        $responseData = ['status' => false, 'error' => 'Empresa no encontrada.'];
        apiUnityLog($endpoint, 'RESPONSE', '404', $responseData);
        echo json_encode($responseData);
        exit;
    }

    $stmtHistorial = $db->prepare(
        'SELECT id, creditos_anteriores, creditos_nuevos, diferencia, tipo, origen, observacion, created_at
         FROM company_creditos_historial
         WHERE id_company = :id_company
         ORDER BY id DESC'
    );
    $stmtHistorial->execute([':id_company' => $id_company]);
    $historial = $stmtHistorial->fetchAll(PDO::FETCH_ASSOC);

    $creditos_originales = (int) $company['creditos_originales'];
    $creditos = (int) $company['creditos'];

    $responseData = [
        'status' => true,
        'id_company' => (int) $company['id'],
        'empresa' => $company['name'],
        'creditos_originales' => $creditos_originales,
        'creditos' => $creditos,
        'consumidos' => max(0, $creditos_originales - $creditos),
        'historial' => $historial,
    ];

    apiUnityLog($endpoint, 'RESPONSE', '200 OK', $responseData);
    echo json_encode($responseData);
} catch (PDOException $ex) {
    http_response_code(500);
    $responseData = ['status' => false, 'error' => 'Error en la consulta: ' . $ex->getMessage()];
    apiUnityLog($endpoint, 'ERROR', 'PDOException', $responseData);
    echo json_encode($responseData);
} catch (Exception $ex) {
    http_response_code(500);
    $responseData = ['status' => false, 'error' => 'Error general: ' . $ex->getMessage()];
    apiUnityLog($endpoint, 'ERROR', 'Exception', $responseData);
    echo json_encode($responseData);
}
