<?php
require("conexion.php");

// Recibir los datos del JSON y otros parámetros
$cabecera_id = $_POST['cabecera_id'];
$nuevoIntento = $_POST['intento'];
$note = $_POST['note'];
$note_reference = $_POST['note_reference'];
$start_date = $_POST['start_date'];
$end_date = $_POST['end_date'];
$rol = $_POST['rol'];
$jsonData = $_POST['json']; // Esto ya contiene el JSON decodificado
// Puedes acceder a los elementos del JSON directamente
$jsonData = json_decode($jsonData, true); // Convertirlo en un arreglo asociativo si lo deseas

// Imprimir el JSON en formato legible
try {
  $db->exec("SET TIME ZONE 'America/Lima'");

  // Validar el intento antes de actualizar
  $stmt = $db->prepare("SELECT num_report FROM induction_workers WHERE id = :cabecera_id");
  $stmt->bindParam(':cabecera_id', $cabecera_id);
  $stmt->execute();
  $intentos = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($intentos['num_report'] < $nuevoIntento) {
    // Iniciar una transacción
    $db->beginTransaction();

    try {
      // Actualizar Intento
      $stmtUpdate = $db->prepare("UPDATE induction_workers SET num_report = :intento, updated_at = CURRENT_TIMESTAMP WHERE id = :cabecera_id");
      $stmtUpdate->bindParam(':intento', $nuevoIntento);
      $stmtUpdate->bindParam(':cabecera_id', $cabecera_id);
      $stmtUpdate->execute();

      if ($stmtUpdate->rowCount() > 0) {
        echo "Bandera Cabecera<br>";

        // La actualización se realizó con éxito
        // Inicializa una variable para contar los casos insertados
        $totalCasosInsertados = 0;
        $error = false;

        // Recorrer el JSON y validar los registros en detail_induction_workers
        // Verificar si ya existe un registro en detail_induction_workers
        $stmtCheck = $db->prepare("SELECT COUNT(*) as count FROM detail_induction_workers WHERE induction_worker_id = :cabecera_id AND report = :nuevoIntento");
        $stmtCheck->bindParam(':cabecera_id', $cabecera_id);
        $stmtCheck->bindParam(':nuevoIntento', $nuevoIntento);
        $stmtCheck->execute();
        $count = $stmtCheck->fetch(PDO::FETCH_ASSOC);

        foreach ($jsonData as $item) {
          echo "Iteración del bucle para el caso: " . $item['case'] . "<br>";

          if ($count['count'] == 0) {
            // No existe un registro, puedes insertarlo
            $stmtInsert = $db->prepare('INSERT INTO detail_induction_workers (induction_worker_id, "case", identified, risk_level, correct_measure, "time", difficulty, report, note, note_reference, "start_date", end_date, num_errors,"json",rol) VALUES (:induction_worker_id, :case, :identified, :risk_level, :correct_measure, :time, :difficulty, :report, :note, :note_reference, :start_date, :end_date, :num_errors,:json,:rol)');
            $stmtInsert->bindParam(':induction_worker_id', $cabecera_id);
            $stmtInsert->bindParam(':case', $item['case']);
            $stmtInsert->bindParam(':identified', $item['identified']);
            $stmtInsert->bindParam(':risk_level', $item['risk_level']);
            $stmtInsert->bindParam(':correct_measure', $item['correct_measure']);
            $stmtInsert->bindParam(':time', $item['time']);
            $stmtInsert->bindParam(':difficulty', $item['difficulty']);
            $stmtInsert->bindParam(':json', json_encode($item['json']));
            $stmtInsert->bindParam(':rol', $rol);
            $stmtInsert->bindParam(':report', $nuevoIntento);
            $stmtInsert->bindParam(':note', $note, PDO::PARAM_STR);
            $stmtInsert->bindParam(':note_reference', $note_reference, PDO::PARAM_STR);
            $stmtInsert->bindParam(':start_date', $start_date, PDO::PARAM_STR); // Asegúrate de que $start_date sea un string con formato de fecha válido
            $stmtInsert->bindParam(':end_date', $end_date, PDO::PARAM_STR); // Asegúrate de que $end_date sea un string con formato de fecha válido
            $stmtInsert->bindParam(':num_errors', $item['num_errors']); // Reemplaza $num_errors con el valor que desees insertar

            if ($stmtInsert->execute()) {
              echo "Inserción exitosa para el caso: " . $item['case'] . "<br>";
            } else {
              // Se encontró un error en la inserción
              $error = true;
              echo "Error en la inserción para el caso: " . $item['case'] . "<br>";
              break; // Salir del bucle para evitar más inserciones
            }
            $totalCasosInsertados++;
          }
        }

        if ($error) {
          // Si se encuentra un error en la inserción, revertir la transacción
          $db->rollBack();
          echo json_encode(['error' => 'Error en la inserción de casos. Se eliminaron todos los registros y no se realizó la actualización.']);
        } else {
          // Si todo va bien, confirmar la transacción
          $db->commit();
          $mensajeRespuesta = 'Actualización exitosa';
          if ($totalCasosInsertados > 0) {
            $mensajeRespuesta .= ". Se insertaron $totalCasosInsertados casos.";
          }
          echo json_encode(['success' => $mensajeRespuesta]);
        }
      } else {
        echo json_encode(['error' => 'No se actualizó ningún registro.']);
      }
    } catch (PDOException $ex) {
      // En caso de error en la actualización
      $db->rollBack();
      echo json_encode(['error' => 'Error en la actualización: ' . $ex->getMessage()]);
    }
  } else {
    echo json_encode(['error' => 'Ya existe un reporte generado para este intento']);
  }
} catch (PDOException $ex) {
  // Manejar errores PDO
  echo json_encode(['error' => 'Error en la consulta: ' . $ex->getMessage()]);
} finally {
  // Restablecer la zona horaria de la sesión a su valor predeterminado
  $db->exec("RESET TIME ZONE");
}
