<?php
require("conexion.php");

// Definir los parámetros en un array
// $query_params = array(
//     ':id_worker' => '13',
//     ':id_induction' => '8',
//     ':note' => '20',
//     ':reference_note' => '20',
//     ':case_count' => '2',
//     ':shift' => 'Dia',
//     ':start_date' => '12/12/12',
//     ':end_date' => '12/12/12'
// );

$query_params = array(
    ':id_worker' => $_POST['id_worker'],
    ':id_induction' => $_POST['id_induction'],
    ':note' => $_POST['note'],
    ':reference_note' => $_POST['reference_note'],
    ':case_count' => $_POST['case_count'],
    ':shift' => $_POST['shift'],
    ':start_date' => $_POST['start_date'],
    ':end_date' => $_POST['end_date']
);

$queryInductionWorkerUpdate = "
UPDATE induction_workers
SET
  note = :note,
  reference_note = :reference_note,
  case_count = :case_count,
  shift = :shift,
  start_date = :start_date,
  end_date = :end_date
WHERE
  id_worker = :id_worker
  AND id_induction = :id_induction;
";

$query_params_DetailInductionWorkerDelete = array(
    ':induction_worker' => $_POST['induction_worker']
);

$queryDetailInductionWorkerDelete = "
DELETE FROM detail_induction_workers
WHERE induction_worker_id = :induction_worker;
";

try {
    // Actualizar datos en la tabla induction_workers
    $stmtUpdate = $db->prepare($queryInductionWorkerUpdate);
    // Bind de los parámetros utilizando el array
    $stmtUpdate->execute($query_params);
    // Verificar si la actualización se realizó correctamente
    // Eliminar registros de la tabla detail_induction_workers
    $stmtDelete = $db->prepare($queryDetailInductionWorkerDelete);
    // Bind de los parámetros utilizando el array
    $stmtDelete->execute($query_params_DetailInductionWorkerDelete);
    echo json_encode(array('success' => 'Actualizacion existosa de Nota.'));
} catch (PDOException $ex) {
    echo json_encode(array('error' => 'Error en la consulta: ' . $ex->getMessage()));
}
