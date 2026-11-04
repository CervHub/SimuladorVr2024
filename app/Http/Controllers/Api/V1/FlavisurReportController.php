<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\DetailInductionWorker;
use App\Models\InductionWorker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FlavisurReportController extends Controller
{
    public function submit(Request $request)
    {
        $request->validate([
            'cabecera_id' => 'required|integer|min:1',
            'detail_induction_worker_id' => 'prohibited',
            'intento' => 'required|integer|min:1',
            'entrenamiento' => 'sometimes|boolean',
            'json_data' => 'required',
        ]);
        $payload = $request->input('json_data');
        if (is_string($payload)) {
            $payload = json_decode($payload, true);
        }
        if (!is_array($payload) || !isset($payload['condition']['shovelModel'], $payload['collisions'], $payload['buckets'], $payload['trucks'], $payload['times'])) {
            return response()->json(['status' => false, 'message' => 'JSON de pala minera inválido.'], 422);
        }

        return DB::transaction(function () use ($request, $payload) {
            $registration = InductionWorker::whereKey($request->cabecera_id)->lockForUpdate()->first();
            if (!$registration) {
                return response()->json(['status' => false, 'message' => 'Cabecera no encontrada.'], 404);
            }
            $induction = $registration->induction;
            if (!$induction || $induction->id_company != 12 || $induction->id_workshop != 40) {
                return response()->json(['status' => false, 'message' => 'Este flujo corresponde solo a Pala Minera de Flavisur.'], 422);
            }
            if ($registration->status != 1 || $induction->status != 1) {
                return response()->json(['status' => false, 'message' => 'La inscripción o inducción no está activa.'], 422);
            }
            $attempt = (int) $request->intento;
            $training = $request->boolean('entrenamiento');
            if (!$training && $attempt > $induction->intentos) {
                return response()->json(['status' => false, 'message' => 'Superó el máximo de intentos.'], 422);
            }
            $detail = $registration->detail()->where('report', $attempt)
                ->where('entrenamiento', $training ? 1 : 0)->orderByDesc('id')->first();
            $replaced = $detail && $detail->json !== null;
            if (!$detail) {
                $detail = new DetailInductionWorker([
                    'induction_worker_id' => $registration->id, 'report' => $attempt,
                    'entrenamiento' => $training ? 1 : 0, 'case' => 'Pala minera',
                    'identified' => 0, 'risk_level' => 0, 'correct_measure' => 0,
                    'difficulty' => '', 'num_errors' => 0, 'start_date' => '', 'end_date' => '',
                ]);
            }
            $detail->fill([
                'json' => $payload, 'note' => DetailInductionWorker::palaMineraNota($payload),
                'note_reference' => 20, 'time' => $payload['times']['Total'] ?? '00:00:00',
            ])->save();
            if (!$training && $attempt > $registration->num_report) {
                $registration->num_report = $attempt;
                $registration->save();
            }
            $mode = $training ? 'Entrenamiento' : 'Evaluación';
            return response()->json([
                'status' => true, 'message' => $replaced ? 'Reporte reemplazado correctamente.' : 'Reporte guardado correctamente.',
                'replaced' => (bool) $replaced, 'detail_induction_worker_id' => $detail->id,
                'pdf_url' => url("view/pdf/{$registration->id}/{$attempt}/{$mode}"),
            ]);
        });
    }
}
