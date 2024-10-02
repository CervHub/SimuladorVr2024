<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\InductionWorker;
use App\Models\Worker;
use Carbon\Carbon;
use App\Models\DetailInductionWorker;

class ApiIsemController extends Controller
{
    public function induction(Request $request, $dni)
    {
        $worker = Worker::where('code_worker', 'LIKE', '%' . '-' . $dni)
            ->where('id_company', 2)
            ->first();
        
        if ($worker) {
            $inducciones = InductionWorker::join('inductions', 'induction_workers.id_induction', '=', 'inductions.id')
                ->join('workshops as w', 'inductions.id_workshop', '=', 'w.id') // Inner join con workshops
                ->where('induction_workers.id_worker', $worker->id)
                ->where('inductions.date_end', '>=', Carbon::now())
                ->where('inductions.date_start', '<=', Carbon::now())
                ->whereTime('inductions.time_end', '>=', Carbon::now())
                ->whereTime('inductions.time_start', '<=', Carbon::now())
                ->select(
                    'inductions.id as induction_id',
                    'w.id as id_workshop',
                    'induction_workers.id as induction_workers',
                    'inductions.date_start',
                    'inductions.date_end',
                    'inductions.time_start',
                    'inductions.time_end',
                    'w.name as name',
                )
                ->get();
                

            $responseData = [
                'dni' => $dni,
                'id_worker' => $worker->id,
                'worker' => $worker->code_worker,
                'nombre' => $worker->user->name,
                'apellido' => $worker->user->last_name,
                'inducciones' => $inducciones,
            ];
            return response()->json($responseData);
        } else {
            return response()->json("Usuario no existe");
        }
    }
    public function insertcasos(Request $request, $json)
    {
        // https://simuladoresvr.cursso.digital/isem/v1/insertcasos/{"induction_worker_id": 18, "case": "Ejemplo Caso 01", "identified": 4.0, "risk_level": 0.5, "correct_measure": 0.8, "time": "120", "difficulty": "Moderate"}
        // Decodifica el JSON desde la URL
        $jsonData = json_decode(urldecode($json), true);

        // Define los campos requeridos
        $requiredFields = ['induction_worker_id', 'case', 'identified', 'risk_level', 'correct_measure', 'time', 'difficulty'];

        // Verifica que todos los campos requeridos estén presentes en el JSON
        foreach ($requiredFields as $field) {
            if (!isset($jsonData[$field])) {
                return response()->json(['message' => "Falta el campo requerido: $field"], 400);
            }
        }

        // Crea un nuevo registro
        try {
            $detailInductionWorker = new DetailInductionWorker();
            $detailInductionWorker->induction_worker_id = $jsonData['induction_worker_id'];
            $detailInductionWorker->case = $jsonData['case'];
            $detailInductionWorker->identified = $jsonData['identified'];
            $detailInductionWorker->risk_level = $jsonData['risk_level'];
            $detailInductionWorker->correct_measure = $jsonData['correct_measure'];
            $detailInductionWorker->time = $jsonData['time'];
            $detailInductionWorker->difficulty = $jsonData['difficulty'];
            $detailInductionWorker->save();

            // Responde con un JSON exitoso
            return response()->json(['message' => 'Registro creado exitosamente'], 201);
        } catch (\Throwable $th) {
            // Responde con un JSON de error
            return response()->json(['message' => 'Error al crear el registro'], 500);
        }
    }

    public function insertnota(Request $request, $json)
    {
        // https://simuladoresvr.cursso.digital/isem/v1/insertcasos/{"id_worker": 13,"id_induction": 5,"note": "18.9", "reference_note": "20.00", "case_count": 4, "shift":"Dia", "start_date": "2023-08-31", "end_date": "2023-09-15"}

        // Decodifica el JSON desde la URL
        $jsonData = json_decode(urldecode($json), true);

        // Define los campos requeridos
        $requiredFields = ['id_worker', 'id_induction', 'note', 'reference_note', 'case_count', 'shift', 'start_date', 'end_date'];

        // Verifica que todos los campos requeridos estén presentes en el JSON
        foreach ($requiredFields as $field) {
            if (!isset($jsonData[$field])) {
                return response()->json(['message' => "Falta el campo requerido: $field"], 400);
            }
        }

        // Si todos los campos requeridos están presentes, procede con la actualización
        try {
            // Verifica si el registro existe
            $inductionWorker = InductionWorker::where('id_worker', $jsonData['id_worker'])
                ->where('id_induction', $jsonData['id_induction'])
                ->firstOrFail();

            // Actualiza los datos
            $inductionWorker->note = $jsonData['note'];
            $inductionWorker->reference_note = $jsonData['reference_note'];
            $inductionWorker->case_count = $jsonData['case_count'];
            $inductionWorker->shift = $jsonData['shift'];
            $inductionWorker->start_date = $jsonData['start_date'];
            $inductionWorker->end_date = $jsonData['end_date'];
            $inductionWorker->save();

            DetailInductionWorker::where('induction_worker_id', $inductionWorker->id)->delete();

            // Responde con un JSON exitoso
            return response()->json(['message' => 'Actualización exitosa']);
        } catch (\Throwable $th) {
            // Responde con un JSON de error
            return response()->json(['message' => 'Error al actualizar'], 500);
        }
    }
}
