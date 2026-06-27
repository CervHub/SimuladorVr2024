<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        try {
            $dni = $request->input('dni');

            $user = User::where('doi', $dni)->first();

            if (!$user) {
                return response()->json(['message' => 'Usuario no encontrado'], 401);
            }

            $inductions = $this->getInductions($user->id);

            if (empty($inductions)) {
                return response()->json([
                    'status' => false,
                    'message' => 'No tiene inducciones activas',
                ], 401);
            }

            return response()->json([
                'status' => true,
                'message' => 'Login successful',
                'data' => [
                    'user' => [
                        'id' => $user->id,
                        'name' => $this->toUtf8(trim($user->name . ' ' . $user->last_name)),
                        'dni' => $user->doi,
                    ],
                    'inductions' => $inductions,
                ],
            ], 200, [], JSON_INVALID_UTF8_SUBSTITUTE);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => false,
                'message' => 'Error al procesar el login',
                'error' => $this->toUtf8($e->getMessage()),
            ], 500);
        }
    }

    private function getInductions(int $userId): array
    {
        try {
            $userInductions = DB::select("
                SELECT
                    i.id AS induction_id,
                    COALESCE(i.alias, w.name) AS subject_name,
                    'vr' AS subject_type,
                    COALESCE(s.id, iw.id) AS module_id,
                    COALESCE(s.name, w.name) AS module_name,
                    iw.id AS component_id,
                    w.name AS component_name,
                    COALESCE(
                        (
                            SELECT CASE
                                WHEN COUNT(di.id) = 0 THEN 0
                                ELSE ROUND(
                                    COUNT(CASE WHEN di.json IS NOT NULL THEN 1 END)::numeric
                                    / COUNT(di.id)::numeric * 100
                                )
                            END
                            FROM detail_induction_workers di
                            WHERE di.induction_worker_id = iw.id
                        ),
                        0
                    ) AS component_progress
                FROM workers AS wr
                INNER JOIN induction_workers AS iw ON iw.id_worker = wr.id
                INNER JOIN inductions AS i ON i.id = iw.id_induction
                INNER JOIN workshops AS w ON w.id = i.id_workshop
                LEFT JOIN steps AS s ON s.workshop_id = w.id
                WHERE wr.id_user = ?
                  AND wr.id_role = 4
                  AND iw.status = '1'
                  AND i.status = '1'
                  AND NOW() BETWEEN (i.date_start || ' ' || i.time_start)::timestamp
                                  AND (i.date_end || ' ' || i.time_end)::timestamp
            ", [$userId]);

            return $this->groupInductionData($userInductions);
        } catch (\Exception $e) {
            return [];
        }
    }

    private function groupInductionData(array $rawData): array
    {
        $groupedData = [];

        foreach ($rawData as $row) {
            $inductionId = $row->induction_id;
            $moduleId = $row->module_id;

            if (!isset($groupedData[$inductionId])) {
                $groupedData[$inductionId] = [
                    'induction_id' => $inductionId,
                    'subject_name' => $this->toUtf8($row->subject_name),
                    'subject_type' => $row->subject_type,
                    'modules' => [],
                ];
            }

            if (!isset($groupedData[$inductionId]['modules'][$moduleId])) {
                $groupedData[$inductionId]['modules'][$moduleId] = [
                    'module_id' => $moduleId,
                    'module_name' => $this->toUtf8($row->module_name),
                    'component_id' => $row->component_id,
                    'component_name' => $this->toUtf8($row->component_name),
                    'component_progress' => (int) ($row->component_progress ?? 0),
                    'questions' => [],
                ];
            }
        }

        foreach ($groupedData as &$induction) {
            $induction['modules'] = array_values($induction['modules']);
        }

        return array_values($groupedData);
    }

    private function toUtf8(?string $value): ?string
    {
        if ($value === null || $value === '') {
            return $value;
        }

        if (mb_check_encoding($value, 'UTF-8')) {
            return $value;
        }

        return mb_convert_encoding($value, 'UTF-8', 'ISO-8859-1');
    }
}
