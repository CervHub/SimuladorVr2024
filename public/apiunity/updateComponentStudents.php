<?php

require("conexion.php");

$query_check = "
    SELECT 1
    FROM component_students
    WHERE student_id = :student_id
      AND component_id = :component_id
      AND induction_id = :induction_id
";

$query_update = "
    UPDATE component_students
    SET score = :score, pass = :pass, used_time = :used_time
    WHERE student_id = :student_id
      AND component_id = :component_id
      AND induction_id = :induction_id
";

$query_params_check = array(
    ':component_id' => 121,
    ':student_id' => 15,
    ':induction_id' => 16
);

$query_params_update = array(
    ':component_id' => 121,
    ':student_id' => 15,
    ':induction_id' => 16,
    ':score' => 17,
    ':pass' => 'SI',
    ':used_time' => 120
);

// $query_params_check = array(
//     ':student_id' => $_POST['student_id'],
//     ':component_id' => $_POST['component_id'],
//     ':induction_id' => $_POST['induction_id']
// );

// $query_params_update = array(
//     ':student_id' => $_POST['student_id'],
//     ':component_id' => $_POST['component_id'],
//     ':induction_id' => $_POST['induction_id'],
//     ':score' => $_POST['score'],
//     ':pass' => $_POST['pass'],
//     ':used_time' => $_POST['used_time']
// );


try {
    $stmt_check = $db->prepare($query_check);
    $stmt_check->execute($query_params_check);
// Fetch the result of the statement execution
$result = $stmt_check->fetch(PDO::FETCH_ASSOC);

// Display the result
echo json_encode($result);
    if ($stmt_check->rowCount() === 0) {
        echo json_encode(array('message' => 'Row does not exist'));
    } else {
        // Row exists, perform the update
        $stmt_update = $db->prepare($query_update);
        $stmt_update->execute($query_params_update);

        echo json_encode(array('message' => 'Row updated successfully'));
    }
} catch (PDOException $ex) {
    die(json_encode(array('message' => 'Error in query')));
}
?>
