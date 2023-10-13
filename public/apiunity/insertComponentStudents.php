<?php

require("conexion.php");

$query_check = "
    SELECT 1
    FROM component_students
    WHERE student_id = :student_id
      AND component_id = :component_id
      AND induction_id = :induction_id
";

$query_insert = "
    INSERT INTO component_students (component_id, student_id, score, pass, used_time, induction_id)
    VALUES (:component_id, :student_id, 0, 'NO', 0, :induction_id)
";

$query_params_check = array(
    ':component_id' => 121,
    ':student_id' => 15,
    ':induction_id' => 16
);

try {
    $stmt_check = $db->prepare($query_check);
    $stmt_check->execute($query_params_check);

    if ($stmt_check->rowCount() === 0) {
        // Row doesn't exist, perform the insert
        $query_params_insert = array(
            ':component_id' => 121,
            ':student_id' => 15,
            ':induction_id' => 16
        );
        // $query_params_insert = array(
        //     ':component_id' => $_POST['component_id'],
        //     ':student_id' => $_POST['student_id'],
        //     ':induction_id' => $_POST['induction_id']
        // );

        $stmt_insert = $db->prepare($query_insert);
        $stmt_insert->execute($query_params_insert);

        echo json_encode(array('message' => 'Row inserted successfully'));
    } else {
        echo json_encode(array('message' => 'Row already exists'));
    }
} catch (PDOException $ex) {
    die(json_encode(array('message' => 'Error in query')));
}
?>
