<?php

require("conexion.php");

if (!empty($_POST)) {
    $query = " 
                SELECT * FROM detail_induction_workers WHERE induction_worker_id = :induction_worker_id
                ";  
    $query_params = array(
        ':induction_worker_id' => $_POST['induction_worker_id']
    );
    try {
        $stmt   = $db->prepare($query);
        $result = $stmt->execute($query_params);
        $arrayData = array();
    }
    catch (PDOException $ex) {      
         die(json_encode($arrayData));
        
    }
    $validated_info = false;

    while($row = $stmt->fetch())
    {
        $arrayData['induction'][] = $row;
    }
    die(json_encode($arrayData));
}

?>