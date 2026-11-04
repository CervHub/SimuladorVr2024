<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\DetailInductionWorker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function submit(Request $request)
    {
        try {
            $request->validate([
                'detail_induction_worker_id' => 'required|numeric',
                'json_data' => 'required',
            ]);

            $jsonData = $request->input('json_data');
            if (is_string($jsonData)) {
                $jsonData = json_decode($jsonData, true);
                if (json_last_error() !== JSON_ERROR_NONE) {
                    throw new \Exception('El formato de los datos JSON no es válido.');
                }
            } elseif (! is_array($jsonData)) {
                throw new \Exception('json_data debe ser un objeto JSON o un string JSON válido.');
            }

            $detailInductionWorker = DetailInductionWorker::find($request->detail_induction_worker_id);
            if (!$detailInductionWorker) {
                return response()->json([
                    'status' => false,
                    'message' => 'No se encontró el registro de la evaluación.',
                ], 404);
            }

            if (!is_null($detailInductionWorker->json)) {
                return response()->json([
                    'status' => false,
                    'message' => 'El campo JSON ya ha sido actualizado previamente y no se puede actualizar nuevamente.',
                ], 400);
            }

            DB::beginTransaction();
            try {
                $detailInductionWorker->update(['json' => $jsonData]);
                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }

            $inductionWorkerId = $detailInductionWorker->induction_worker_id;
            $intento = $detailInductionWorker->report;
            $modo = $detailInductionWorker->entrenamiento == 1 ? 'Entrenamiento' : 'Evaluación';

            return response()->json([
                'status' => true,
                'message' => 'Datos recibidos correctamente.',
                'pdf_url' => url("view/pdf/{$inductionWorkerId}/{$intento}/{$modo}"),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Ocurrió un error al procesar la solicitud.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
