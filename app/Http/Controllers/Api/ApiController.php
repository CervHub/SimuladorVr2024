<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Worker;
use App\Models\InductionWorker;
use App\Models\DetailInductionWorker;
use App\Models\Induction;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ApiController extends Controller
{
    private function authenticate($company_id, $dni, $password, $user_type = '300')
    {
        // Asegurarse de que el company_id tenga 3 dígitos
        $formatted_company_id = str_pad($company_id, 3, '0', STR_PAD_LEFT);

        // Formatear el código del trabajador con el tipo de usuario
        $code_worker = $user_type . '-' . $formatted_company_id . '-' . $dni;

        // Buscar al trabajador y su usuario por el código del trabajador
        $worker = Worker::where('code_worker', $code_worker)
            ->with('user')
            ->first();

        // Verificar si el trabajador existe y la contraseña es correcta
        if (!$worker || !Hash::check($password, $worker->user->password)) {
            return null;
        }

        // Autenticación exitosa, devolver los datos del trabajador
        return [
            'name' => $worker->nombre,
            'last_name' => $worker->apellido,
            'worker_id' => $worker->id,
            'code_worker' => $worker->code_worker,
            'user_id' => $worker->user->id,
        ];
    }

    private function getWorkshops($code_worker) {}


    public function login(Request $request)
    {
        try {
            // Validar los datos de entrada
            $request->validate([
                'company_id' => 'required|numeric',
                'dni' => 'required|string',
                'password' => 'required|string',
            ]);

            // Llamar al método de autenticación
            $auth_result = $this->authenticate($request->company_id, $request->dni, $request->password);

            if (!$auth_result) {
                return response()->json([
                    'status' => false,
                    'message' => 'Credenciales incorrectas o instructor no autorizado.'
                ], 401);
            }

            return response()->json(
                [
                    'status' => true,
                    'message' => 'Inicio de sesión exitoso.',
                    'data' => $auth_result
                ]
            );
        } catch (ValidationException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Error de validación.',
                'errors' => $e->errors()
            ], 422);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Ocurrió un error durante el inicio de sesión.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    private function findWorker($company_id, $dni)
    {
        // Company ID debe tener 3 dígitos
        $formatted_company_id = str_pad($company_id, 3, '0', STR_PAD_LEFT);
        // Cabecera del ID
        $code_worker_header = '400-' . $formatted_company_id . '-';

        // Buscar al trabajador por code_worker
        // Que empiece con '400-<company_id>-' y termine con el DNI
        $worker = Worker::where('code_worker', 'like', $code_worker_header . '%')
            ->where('code_worker', 'like', '%' . $dni)
            ->first();

        if ($worker) {
            return [
                'id' => $worker->id,
                'name' => $worker->nombre,
                'last_name' => $worker->apellido,
                'code_worker' => $worker->code_worker,
                'position' => $worker->position,
                'license' => $worker->license ?? '',
                'category' => $worker->category ?? '',
                'photo' => $worker->photo ?? '',
            ];
        }
        return null;
    }

    // private function getWorkshops($code_worker) {}

    public function loginUser(Request $request)
    {
        try {
            // Validar los datos de entrada
            $request->validate([
                'dni' => 'required|string',
                'company_id' => 'required|numeric',
                // 'password' => 'required|string',
            ]);

            $worker = $this->findWorker($request->company_id, $request->dni);

            if (!$worker) {
                return response()->json([
                    'status' => false,
                    'message' => 'Trabajador no encontrado.'
                ], 404);
            }

            $whorkshops = $this->getWorkerWhorkshops($worker['id']);

            return response()->json([
                'status' => true,
                'message' => 'Trabajador encontrado.',
                'data' => $worker,
                'whorkshops' => $whorkshops
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Error de validación.',
                'errors' => $e->errors()
            ], 422);
        } catch (Exception $ex) {
            return response()->json([
                'status' => false,
                'message' => 'Error general: ' . $ex->getMessage()
            ], 500);
        }
    }

    private function getWorkerWhorkshops($workerId, $timeZone = 'UTC+05:00')
    {

        // Construct the SQL statement dynamically to set the time zone
        DB::statement("SET TIME ZONE '$timeZone'");

        $result = DB::select("
            SELECT
                iw.id AS induction_worker_id,
                iw.id_induction AS induction_id,
                i.alias AS workshop,
                i.date_start || ' ' || i.time_start AS start_date,
                i.date_end || ' ' || i.time_end AS end_date,
                iw.num_report + 1 AS current_attempt,
                i.intentos AS total_attempts,
                NOW() AS current_date
            FROM induction_workers AS iw
            INNER JOIN inductions AS i ON iw.id_induction = i.id
            WHERE iw.id_worker = ?
            AND iw.status = '1'
            AND iw.num_report + 1 <= i.intentos
            AND NOW() BETWEEN (i.date_start || ' ' || i.time_start)::timestamp AND (i.date_end || ' ' || i.time_end)::timestamp
        ", [$workerId]);

        // Reset the time zone to the default
        DB::statement("SET TIME ZONE DEFAULT");

        return $result;
    }


    public function createWorkshop(Request $request)
    {
        try {
            $request->validate([
                'induction_worker_id' => 'required|numeric', // Obligatorio
                'attempt' => 'required|numeric', // Obligatorio
                'is_training' => 'required|boolean' // Obligatorio
            ]);

            $is_training = $request->is_training;

            // Validar si existe el registro de la inducción
            $exists = InductionWorker::where('id', $request->induction_worker_id)
                ->exists();

            if (!$exists) {
                return response()->json([
                    'status' => false,
                    'message' => 'No se encontró el registro de la inducción.'
                ], 404);
            }

            if ($is_training) {
                $count_attempts = DetailInductionWorker::where('induction_worker_id', $request->induction_worker_id)
                    ->where('entrenamiento', '1')
                    ->distinct('report')
                    ->count('report');


                $detail_induction_worker = DetailInductionWorker::create([
                    'induction_worker_id' => $request->induction_worker_id,
                    'report' => $count_attempts + 1,
                    'case' => '',
                    'note' => 0,
                    'note_reference' => 0,
                    'start_date' => '',
                    'end_date' => '',
                    'entrenamiento' => 1
                ]);

                return response()->json([
                    'status' => true,
                    'message' => 'Entrenamiento creado correctamente.',
                    'data' => $detail_induction_worker
                ]);
            } else {
                // Validar si existen intentos
                $have_current_attempt = DetailInductionWorker::where('induction_worker_id', $request->induction_worker_id)
                    ->where('report', $request->attempt)
                    ->where('entrenamiento', '0')
                    ->exists();

                if ($have_current_attempt) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Ya existe un registro con el intento actual.'
                    ], 400);
                }



                $detail_induction_worker = DetailInductionWorker::create([
                    'induction_worker_id' => $request->induction_worker_id,
                    'report' => $request->attempt,
                    'case' => '',
                    'note' => 0,
                    'note_reference' => 0,
                    'start_date' => '',
                    'end_date' => '',
                    'entrenamiento' => 0
                ]);

                // AUmenta en 1 el current_attempt
                InductionWorker::where('id', $request->induction_worker_id)
                    ->increment('num_report');

                return response()->json([
                    'status' => true,
                    'message' => 'Evaluación creada correctamente.',
                    'data' => $detail_induction_worker
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Ocurrió un error al procesar la solicitud.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function uploadWorkshop(Request $request)
    {
        try {
            $request->validate([
                'detail_induction_worker_id' => 'required|numeric', // Obligatorio
                'json_data' => 'required|json' // Obligatorio y debe ser JSON válido
            ]);

            // Procesar los datos JSON
            $jsonData = json_decode($request->input('json_data'), true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new \Exception('El formato de los datos JSON no es válido.');
            }

            // Validar si existe el registro de la detail_induction_worker_id
            $detailInductionWorker = DetailInductionWorker::find($request->detail_induction_worker_id);
            if (!$detailInductionWorker) {
                return response()->json([
                    'status' => false,
                    'message' => 'No se encontró el registro de la evaluación.'
                ], 404);
            }

            // Verificar si el campo json ya ha sido actualizado previamente
            if (!is_null($detailInductionWorker->json)) {
                return response()->json([
                    'status' => false,
                    'message' => 'El campo JSON ya ha sido actualizado previamente y no se puede actualizar nuevamente. '
                ], 400);
            }

            // Usar transacción para asegurar la consistencia de la base de datos
            DB::beginTransaction();
            try {
                // Actualizar los datos de la evaluación
                $detailInductionWorker->update([
                    'json' => $jsonData
                ]);

                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }

            return response()->json([
                'status' => true,
                'message' => 'Datos recibidos correctamente.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Ocurrió un error al procesar la solicitud.',
                'error' => $e->getMessage()
            ], 500);
        } finally {
            // Aquí puedes agregar cualquier limpieza si es necesario
        }
    }
}
