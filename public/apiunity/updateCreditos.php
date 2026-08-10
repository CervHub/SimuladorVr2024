<?php

require('conexion.php');
require('logger.php');

$endpoint = 'updateCreditos';
$id_company = $_POST['id_company'] ?? null;
$creditos_consumidos = $_POST['creditos_consumidos'] ?? null;
$observacion = $_POST['observacion'] ?? null;

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

    if ($creditos_consumidos === null || $creditos_consumidos === '' || !is_numeric($creditos_consumidos)) {
        http_response_code(422);
        $responseData = ['status' => false, 'error' => 'creditos_consumidos es requerido y debe ser numérico.'];
        apiUnityLog($endpoint, 'RESPONSE', '422', $responseData);
        echo json_encode($responseData);
        exit;
    }

    $creditos_consumidos = (int) $creditos_consumidos;
    if ($creditos_consumidos <= 0) {
        http_response_code(422);
        $responseData = ['status' => false, 'error' => 'creditos_consumidos debe ser mayor a 0.'];
        apiUnityLog($endpoint, 'RESPONSE', '422', $responseData);
        echo json_encode($responseData);
        exit;
    }

    $db->beginTransaction();

    $stmt = $db->prepare('SELECT id, name, creditos, creditos_originales FROM companies WHERE id = :id_company FOR UPDATE');
    $stmt->execute([':id_company' => $id_company]);
    $company = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$company) {
        $db->rollBack();
        http_response_code(404);
        $responseData = ['status' => false, 'error' => 'Empresa no encontrada.'];
        apiUnityLog($endpoint, 'RESPONSE', '404', $responseData);
        echo json_encode($responseData);
        exit;
    }

    $creditos_anteriores = (int) $company['creditos'];
    $creditos_originales = (int) $company['creditos_originales'];

    if ($creditos_consumidos > $creditos_anteriores) {
        $db->rollBack();
        http_response_code(422);
        $responseData = [
            'status' => false,
            'error' => 'No hay créditos suficientes.',
            'creditos_originales' => $creditos_originales,
            'creditos' => $creditos_anteriores,
            'creditos_consumidos_solicitados' => $creditos_consumidos,
        ];
        apiUnityLog($endpoint, 'RESPONSE', '422', $responseData);
        echo json_encode($responseData);
        exit;
    }

    $creditos_nuevos = $creditos_anteriores - $creditos_consumidos;
    $diferencia = -$creditos_consumidos; // negativo = consumo

    // Solo resta del saldo disponible; no toca creditos_originales
    $stmtUpdate = $db->prepare('UPDATE companies SET creditos = :creditos, updated_at = NOW() WHERE id = :id_company');
    $stmtUpdate->execute([
        ':creditos' => $creditos_nuevos,
        ':id_company' => $id_company,
    ]);

    $stmtHistorial = $db->prepare(
        'INSERT INTO company_creditos_historial
            (id_company, creditos_anteriores, creditos_nuevos, diferencia, tipo, origen, observacion, created_at, updated_at)
         VALUES
            (:id_company, :anteriores, :nuevos, :diferencia, :tipo, :origen, :observacion, NOW(), NOW())'
    );
    $stmtHistorial->execute([
        ':id_company' => $id_company,
        ':anteriores' => $creditos_anteriores,
        ':nuevos' => $creditos_nuevos,
        ':diferencia' => $diferencia,
        ':tipo' => 'consumo',
        ':origen' => 'api',
        ':observacion' => $observacion,
    ]);

    $db->commit();

    $responseData = [
        'status' => true,
        'message' => 'Créditos actualizados.',
        'id_company' => (int) $company['id'],
        'empresa' => $company['name'],
        'creditos_originales' => $creditos_originales,
        'creditos_anteriores' => $creditos_anteriores,
        'creditos_consumidos' => $creditos_consumidos,
        'creditos' => $creditos_nuevos,
        'consumidos_totales' => max(0, $creditos_originales - $creditos_nuevos),
        'diferencia' => $diferencia,
        'tipo' => 'consumo',
    ];

    apiUnityLog($endpoint, 'RESPONSE', '200 OK', $responseData);
    echo json_encode($responseData);
} catch (PDOException $ex) {
    if ($db->inTransaction()) {
        $db->rollBack();
    }
    http_response_code(500);
    $responseData = ['status' => false, 'error' => 'Error en la consulta: ' . $ex->getMessage()];
    apiUnityLog($endpoint, 'ERROR', 'PDOException', $responseData);
    echo json_encode($responseData);
} catch (Exception $ex) {
    if ($db->inTransaction()) {
        $db->rollBack();
    }
    http_response_code(500);
    $responseData = ['status' => false, 'error' => 'Error general: ' . $ex->getMessage()];
    apiUnityLog($endpoint, 'ERROR', 'Exception', $responseData);
    echo json_encode($responseData);
}
