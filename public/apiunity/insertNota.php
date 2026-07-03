<?php
require("conexion.php");
require("jsonFormat.php");

// Function to log messages with date and time
function logMessage($message)
{
    global $logFile;
    $logMessage = "[" . date("Y-m-d H:i:s") . "] $message";
    error_log($logMessage . "\n", 3, $logFile);
}

// Define the log file path
$logFile = 'error.log';

// Recibir los datos del JSON y otros parámetros
$cabecera_id = $_POST['cabecera_id'];
$nuevoIntento = $_POST['intento'];
$note = $_POST['note'];
$note_reference = $_POST['note_reference'];
$start_date = $_POST['start_date'];
$end_date = $_POST['end_date'];
$rol = $_POST['rol'];
$jsonData = $_POST['json']; // Esto ya contiene el JSON decodificado
$entrenamiento = intval($_POST['entrenamiento']);

// Imprimir los valores recibidos
// echo "cabecera_id: " . $cabecera_id . "<br>";
// echo "nuevoIntento: " . $nuevoIntento . "<br>";
// echo "note: " . $note . "<br>";
// echo "note_reference: " . $note_reference . "<br>";
// echo "start_date: " . $start_date . "<br>";
// echo "end_date: " . $end_date . "<br>";
// echo "rol: " . $rol . "<br>";
// echo "jsonData: " . $jsonData . "<br>";
// echo "entrenamiento: " . $entrenamiento . "<br>";

$intentoEntrenamiento = 0;
if ($entrenamiento == 1) {
    $stmt = $db->prepare("SELECT COALESCE(MAX(report) + 1, 1) AS result FROM detail_induction_workers WHERE induction_worker_id = :id AND entrenamiento = '1'");
    $stmt->bindParam(':id', $cabecera_id);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $intentoEntrenamiento = $result['result'];
}

// echo $entrenamiento;

$jsonData = json_decode($jsonData, true);
$jsonFormat = is_array($jsonData) ? detectInsertNotaJsonFormat($jsonData) : 'unknown';

// Log para registrar los valores recibidos
logMessage("cabecera_id: $cabecera_id, nuevoIntento: $nuevoIntento, note: $note, note_reference: $note_reference, start_date: $start_date, end_date: $end_date, rol: $rol, jsonFormat: $jsonFormat, jsonData: " . json_encode($jsonData) . ", entrenamiento: $entrenamiento");

if ($jsonFormat === 'unknown') {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Formato JSON no reconocido. Use casos VR (case) o preguntas teóricas (question_id).']);
    logMessage("Error: formato JSON no reconocido");
    return;
}

// Imprimir el JSON en formato legible
try {
    $db->exec("SET TIME ZONE 'America/Lima'");

    // Validar el intento antes de actualizar
    $stmt = $db->prepare("SELECT num_report, id_induction FROM induction_workers WHERE id = :cabecera_id");
    $stmt->bindParam(':cabecera_id', $cabecera_id);
    $stmt->execute();
    $intentos = $stmt->fetch(PDO::FETCH_ASSOC);
    // Preparar la consulta para obtener intentos de inductions
    $stmt2 = $db->prepare("SELECT intentos FROM inductions WHERE id = :id_induction");
    $stmt2->bindParam(':id_induction', $intentos['id_induction']);
    $stmt2->execute();
    $induction = $stmt2->fetch(PDO::FETCH_ASSOC);
    // 1 >= 5

    // Log para registrar el intento antes de actualizar
    logMessage("Intentos permitidos: {$induction['intentos']}, Intento actual: $nuevoIntento");

    if ($nuevoIntento > $induction['intentos']) {
        echo json_encode(['error' => 'Supero el numero de intentos permitidos, Te excediste']);
        return;
    }

    // 0 < 1
    if ($intentos['num_report'] < $nuevoIntento) {
        // Iniciar una transacción
        $db->beginTransaction();

        if ($intentoEntrenamiento != 0) {
            $nuevoIntento = $nuevoIntento - 1;
        }
        // echo "nuevo intento" . $nuevoIntento;
        try {
            // Actualizar Intento
            $stmtUpdate = $db->prepare("UPDATE induction_workers SET num_report = :intento, updated_at = CURRENT_TIMESTAMP WHERE id = :cabecera_id");
            $stmtUpdate->bindParam(':intento', $nuevoIntento);
            $stmtUpdate->bindParam(':cabecera_id', $cabecera_id);
            $stmtUpdate->execute();

            // echo "Intento Actalizado";
            if ($stmtUpdate->rowCount() > 0) {
                // echo "Bandera Cabecera<br>";

                // La actualización se realizó con éxito
                // Inicializa una variable para contar los casos insertados
                $totalCasosInsertados = 0;
                $error = false;

                // Recorrer el JSON y validar los registros en detail_induction_workers
                // Verificar si ya existe un registro en detail_induction_workers
                if ($intentoEntrenamiento > 0) {
                    $nuevoIntento = $intentoEntrenamiento;
                }

                $stmtCheck = $db->prepare("SELECT COUNT(*) as count FROM detail_induction_workers WHERE induction_worker_id = :cabecera_id AND report = :nuevoIntento");
                $stmtCheck->bindParam(':cabecera_id', $cabecera_id);
                $stmtCheck->bindParam(':nuevoIntento', $nuevoIntento);
                $stmtCheck->execute();
                $count = $stmtCheck->fetch(PDO::FETCH_ASSOC);

                $stmtInsert = $db->prepare('INSERT INTO detail_induction_workers (induction_worker_id, "case", identified, risk_level, correct_measure, "time", difficulty, report, note, note_reference, "start_date", end_date, num_errors,"json",rol, created_at, updated_at, entrenamiento) VALUES (:induction_worker_id, :case, :identified, :risk_level, :correct_measure, :time, :difficulty, :report, :note, :note_reference, :start_date, :end_date, :num_errors,:json,:rol, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, :entrenamiento)');

                if ($jsonFormat === 'quiz') {
                    if ($count['count'] == 0 || $intentoEntrenamiento != 0) {
                        $quizCase = 'Evaluación teórica';
                        $quizIdentified = (string) countQuizCorrect($jsonData);
                        $quizRiskLevel = '0';
                        $quizCorrectMeasure = '0';
                        $quizTime = '0:0';
                        $quizDifficulty = 'Quiz';
                        $quizNumErrors = (string) countQuizErrors($jsonData);
                        $quizJsonStored = buildQuizStorageJson($jsonData);

                        $stmtInsert->bindParam(':induction_worker_id', $cabecera_id);
                        $stmtInsert->bindParam(':case', $quizCase);
                        $stmtInsert->bindParam(':identified', $quizIdentified);
                        $stmtInsert->bindParam(':risk_level', $quizRiskLevel);
                        $stmtInsert->bindParam(':correct_measure', $quizCorrectMeasure);
                        $stmtInsert->bindParam(':time', $quizTime);
                        $stmtInsert->bindParam(':difficulty', $quizDifficulty);
                        $stmtInsert->bindParam(':json', $quizJsonStored);
                        $stmtInsert->bindParam(':rol', $rol);
                        $stmtInsert->bindParam(':report', $nuevoIntento);
                        $stmtInsert->bindParam(':note', $note, PDO::PARAM_STR);
                        $stmtInsert->bindParam(':note_reference', $note_reference, PDO::PARAM_STR);
                        $stmtInsert->bindParam(':start_date', $start_date, PDO::PARAM_STR);
                        $stmtInsert->bindParam(':end_date', $end_date, PDO::PARAM_STR);
                        $stmtInsert->bindParam(':num_errors', $quizNumErrors);
                        $stmtInsert->bindParam(':entrenamiento', $entrenamiento, PDO::PARAM_STR);

                        if ($stmtInsert->execute()) {
                            $totalCasosInsertados = count($jsonData);
                        } else {
                            $error = true;
                        }
                    }
                } else {
                    foreach ($jsonData as $item) {
                        if ($count['count'] == 0 or $intentoEntrenamiento != 0) {
                            $normalized = normalizeLegacyItem($item);
                            $jsonStored = json_encode($normalized['json_payload']);

                            $stmtInsert->bindParam(':induction_worker_id', $cabecera_id);
                            $stmtInsert->bindParam(':case', $normalized['case']);
                            $stmtInsert->bindParam(':identified', $normalized['identified']);
                            $stmtInsert->bindParam(':risk_level', $normalized['risk_level']);
                            $stmtInsert->bindParam(':correct_measure', $normalized['correct_measure']);
                            $stmtInsert->bindParam(':time', $normalized['time']);
                            $stmtInsert->bindParam(':difficulty', $normalized['difficulty']);
                            $stmtInsert->bindParam(':json', $jsonStored);
                            $stmtInsert->bindParam(':rol', $rol);
                            $stmtInsert->bindParam(':report', $nuevoIntento);
                            $stmtInsert->bindParam(':note', $note, PDO::PARAM_STR);
                            $stmtInsert->bindParam(':note_reference', $note_reference, PDO::PARAM_STR);
                            $stmtInsert->bindParam(':start_date', $start_date, PDO::PARAM_STR);
                            $stmtInsert->bindParam(':end_date', $end_date, PDO::PARAM_STR);
                            $stmtInsert->bindParam(':num_errors', $normalized['num_errors']);
                            $stmtInsert->bindParam(':entrenamiento', $entrenamiento, PDO::PARAM_STR);

                            if ($stmtInsert->execute()) {
                                // Inserción exitosa
                            } else {
                                $error = true;
                                break;
                            }
                            $totalCasosInsertados++;
                        }
                    }
                }

                if ($error) {
                    // Si se encuentra un error en la inserción, revertir la transacción
                    $db->rollBack();
                    echo json_encode(['error' => 'Error en la inserción de casos. Se eliminaron todos los registros y no se realizó la actualización.']);
                    error_log($errorMessage . "\n", 3, $logFile);
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
        logMessage("Intentos hechos hasta: {$intentos['num_report']}, Nuevo intento: $nuevoIntento");
    }
} catch (PDOException $ex) {
    // Manejar errores PDO
    echo json_encode(['error' => 'Error en la consulta: ' . $ex->getMessage()]);
    // Log para registrar errores PDO
    logMessage("Error en la consulta: " . $ex->getMessage());
} finally {
    // Log para indicar el final del proceso
    logMessage("Proceso finalizado");
    // Restablecer la zona horaria de la sesión a su valor predeterminado
    $db->exec("RESET TIME ZONE");
}
