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
                    $inductionsArray[] = [
                        'dni' => $induction_worker->worker->user->doi,
                        'intento' => $induction_worker->num_report,
                        'induction' => [
                            'induction_id' => $induction->id,
                            'id_workshop' => $induction->id_workshop,
                            'cabecera_id' => $induction_worker->id,
                            'intento' => $induction_worker->num_report,
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
                        ]
                    ];
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
