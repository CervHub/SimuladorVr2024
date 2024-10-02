<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Induction;
use App\Models\InductionWorker; // Asegúrate de importar el modelo InductionWorker

use Carbon\Carbon;
use DateTimeZone; // Importa la clase DateTimeZone

class ApiOffline extends Controller
{
    public function DownloadData(Request $request)
    {
        $default_steps = [
            'Aislamiento y bloqueo de energías' => [
                'pasos' => [
                    ['name' => 'Inspección de zona de trabajo', 'duration' => 2400],
                    ['name' => 'Selección de EPPs', 'duration' => 300],
                    ['name' => 'Selección de accesorios de bloqueo', 'duration' => 300],
                    ['name' => 'Aislamiento de energía', 'duration' => 2400],
                    ['name' => 'Bloqueo y tarjeteo de equipo', 'duration' => 2400]
                ]
            ],
            'Análisis de Fallas' => [
                'pasos' => [
                    ['name' => 'Selección EPPs', 'duration' => 300],
                    ['name' => 'Análisis de fallas en el escenario', 'duration' => 2400]
                ]
            ],
            'Seguridad de Procesos' => [
                'pasos' => [
                    ['name' => 'Selección de EPPs', 'duration' => 300],
                    ['name' => 'Reconocimiento de seguridad industrial y seguridad de procesos', 'duration' => 2400]
                ]
            ]
        ];

        try {
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
                                'pasos' => $default_steps[$induction->alias]['pasos']
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
