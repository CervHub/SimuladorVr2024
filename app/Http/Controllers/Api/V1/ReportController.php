<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\DetailInductionWorker;
use App\Models\InductionWorker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function submit(Request $request)
    {
        try {
            $request->validate([
                'detail_induction_worker_id' => 'required_without:cabecera_id|prohibits:cabecera_id|integer|min:1',
                'cabecera_id' => 'required_without:detail_induction_worker_id|integer|min:1',
                'intento' => 'required_with:cabecera_id|integer|min:1',
                'entrenamiento' => 'sometimes|boolean',
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

            if (!is_array($jsonData)) {
                throw \Illuminate\Validation\ValidationException::withMessages(['json_data' => 'Debe ser un objeto JSON.']);
            }

            if ($request->filled('cabecera_id')) {
                return $this->submitByCabecera($request, $jsonData);
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
                $update = ['json' => $jsonData];
                $registration = \App\Models\InductionWorker::find($detailInductionWorker->induction_worker_id);
                if ($registration && $registration->induction->id_company == 12) {
                    $update['note'] = DetailInductionWorker::palaMineraNota($jsonData);
                    $update['note_reference'] = 20;
                }
                $detailInductionWorker->update($update);
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
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['status' => false, 'message' => 'Datos inválidos.', 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Ocurrió un error al procesar la solicitud.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    private function submitByCabecera(Request $request, array $payload)
    {
        return DB::transaction(function () use ($request, $payload) {
            // Serializa envíos de la misma cabecera para no crear intentos duplicados.
            $registration = InductionWorker::whereKey($request->cabecera_id)->lockForUpdate()->first();
            if (!$registration) {
                return response()->json(['status' => false, 'message' => 'No se encontró la cabecera.'], 404);
            }
            $induction = $registration->induction;
            if (!$induction || $induction->id_company != 12) {
                return response()->json(['status' => false, 'message' => 'Este envío por cabecera corresponde a Flavisur.'], 422);
            }
            if ($registration->status != 1 || $induction->status != 1) {
                return response()->json(['status' => false, 'message' => 'La inscripción o inducción no está activa.'], 422);
            }
            $attempt = (int) $request->intento;
            $training = $request->boolean('entrenamiento');
            if (!$training && $attempt > $induction->intentos) {
                return response()->json(['status' => false, 'message' => 'Superó el número de intentos permitidos.'], 422);
            }
            if (!isset($payload['condition']['shovelModel'], $payload['collisions'], $payload['buckets'], $payload['trucks'], $payload['times'])) {
                throw \Illuminate\Validation\ValidationException::withMessages(['json_data' => 'Faltan los datos del reporte de pala minera.']);
            }
            $detail = $registration->detail()->where('report', $attempt)
                ->where('entrenamiento', $training ? 1 : 0)->lockForUpdate()->first();
            if ($detail && $detail->json !== null) {
                return response()->json(['status' => false, 'message' => 'El intento ya tiene un reporte guardado; no se sobrescribe.'], 400);
            }
            if (!$detail) {
                $detail = new DetailInductionWorker([
                    'induction_worker_id' => $registration->id,
                    'report' => $attempt, 'entrenamiento' => $training ? 1 : 0,
                    'case' => 'Pala minera', 'identified' => 0, 'risk_level' => 0,
                    'correct_measure' => 0, 'time' => $payload['times']['Total'] ?? '00:00:00',
                    'difficulty' => '', 'num_errors' => 0,
                    'start_date' => '', 'end_date' => '',
                ]);
            }
            $detail->fill([
                'json' => $payload,
                'note' => DetailInductionWorker::palaMineraNota($payload),
                'note_reference' => 20,
            ])->save();
            if (!$training && $attempt > $registration->num_report) {
                $registration->num_report = $attempt;
                $registration->save();
            }
            $mode = $training ? 'Entrenamiento' : 'Evaluación';
            return response()->json([
                'status' => true, 'message' => 'Datos recibidos correctamente.',
                'detail_induction_worker_id' => $detail->id,
                'intento' => $attempt,
                'pdf_url' => url("view/pdf/{$registration->id}/{$attempt}/{$mode}"),
            ]);
        });
    }
}
