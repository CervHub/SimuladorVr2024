<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Induction;
use App\Models\InductionWorker; // Asegúrate de importar el modelo InductionWorker
use Illuminate\Support\Facades\DB; // Importa la clase DB para ejecutar consultas SQL
use Carbon\Carbon;
use DateTimeZone; // Importa la clase DateTimeZone

class ApiOffline extends Controller
{
    public function DownloadData(Request $request)
    {
        try {
            // Consulta SQL para obtener los pasos
            $steps = DB::select("
                SELECT workshops.name as taller, steps.name, steps.duration
                FROM steps
                INNER JOIN workshops ON steps.workshop_id = workshops.id
            ");

            // Construir el array $default_steps dinámicamente
            $default_steps = [];
            foreach ($steps as $row) {
                $taller = strtoupper($row->taller); // Convertir el nombre del taller a mayúsculas
                if (!isset($default_steps[$taller])) {
                    $default_steps[$taller] = ['pasos' => []];
                }
                $default_steps[$taller]['pasos'][] = [
                    'name' => $row->name,
                    'duration' => $row->duration
                ];
            }

            $id_company = $request->input('id_company');
            $currentDateTime = Carbon::now(new DateTimeZone('America/Lima'));

            $inductions = Induction::where('id_company', $id_company)
                ->whereRaw("CONCAT(date_end, ' ', time_end) >= ?", [$currentDateTime->toDateTimeString()])
                ->orderBy('id', 'desc')
                ->get();

            $inductionsArray = [];

            foreach ($inductions as $induction) {
                $induction_workers = InductionWorker::where('id_induction', $induction->id)->get();

                foreach ($induction_workers as $induction_worker) {
                    if ($induction_worker->num_report < $induction->intentos) {
                        $taller = strtoupper($induction->alias); // Convertir el nombre del taller a mayúsculas
                        $inductionsArray[] = [
                            'dni' => $induction_worker->worker->user->doi,
                            'intento' => $induction_worker->num_report + 1,
                            'cabecera_id' => $induction_worker->id,
                            'induction' => [
                                'induction_id' => $induction->id,
                                'id_workshop' => $induction->id_workshop,
                                'cabecera_id' => $induction_worker->id,
                                'intento' => $induction_worker->num_report + 1,
                                'intentos' => $induction->intentos,
                                'fecha_inicio' => $induction->date_start . ' ' . $induction->time_start,
                                'fecha_fin' => $induction->date_end . ' ' . $induction->time_end,
                                'taller' => $induction->alias,
                                'nombre' => $induction_worker->worker->nombre,
                                'apellido' => $induction_worker->worker->apellido,
                                'cargo' => $induction_worker->worker->position,
                                'celular' => $induction_worker->worker->celular,
                                'nombre_servicio' => $induction_worker->worker->service->name,
                                'id_service' => $induction_worker->worker->id_service,
                                'pasos' => $default_steps[$taller]['pasos'] ?? [] // Usar los pasos del taller en mayúsculas
                            ]
                        ];
                    }
                }
            }

            return response()->json([
                'success' => true,
                'data' => $inductionsArray
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
}
