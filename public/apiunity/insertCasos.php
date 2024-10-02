<?php
require("conexion.php");

// Define los valores que deseas insertar
$induction_worker_id = 21;
$case = 'asjhdg';
$identified = '12';
$risk_level = '12';
$correct_measure = '2';
$time = '120';
$difficulty = 'alta';

$query_params = array(
    ':induction_worker_id' => $_POST['induction_worker'],
    ':case' => $_POST['case'],
    ':identified' => $_POST['identified'],
    ':risk_level' => $_POST['risk_level'],
    ':correct_measure' => $_POST['correct_measure'],
    ':time' => $_POST['time'],
    ':difficulty' => $_POST['difficulty'],
);

$queryCreateDetailInductionWorker = "
INSERT INTO detail_induction_workers (induction_worker_id, \"case\", identified, risk_level, correct_measure, time, difficulty)
VALUES
  (:induction_worker_id, :case, :identified, :risk_level, :correct_measure, :time, :difficulty);
";

try {
    // Crear un nuevo registro en la tabla detail_induction_workers
    $stmtCreate = $db->prepare($queryCreateDetailInductionWorker);
    // Bind de los parámetros utilizando el array
    $stmtCreate->execute($query_params);

    // Verificar si la creación se realizó correctamente
    if ($stmtCreate->rowCount() > 0) {
        echo json_encode(['message' => 'Registro creado con éxito'], 201); // 201 Created
    } else {
        echo json_encode(['error' => 'No se pudo crear el registro'], 500); // 500 Internal Server Error
    }

} catch (PDOException $ex) {
    echo json_encode(['error' => 'Error en la consulta: ' . $ex->getMessage()], 500); // 500 Internal Server Error
}
?>

