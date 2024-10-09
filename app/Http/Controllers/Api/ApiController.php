<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Worker;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class ApiController extends Controller
{
    public function login(Request $request)
    {
        try {
            // Validar los datos de entrada
            $request->validate([
                'company_id' => 'required|numeric',
                'dni' => 'required|string',
                'password' => 'required|string',
            ]);

            $company_id = $request->company_id;
            // Asegurarse de que el company_id tenga 3 dígitos
            $formatted_company_id = str_pad($company_id, 3, '0', STR_PAD_LEFT);

            // Formatear el código del trabajador
            $code_worker = '300-' . $formatted_company_id . '-' . $request->dni;

            // Buscar al trabajador y su usuario por el código del trabajador
            $worker = Worker::where('code_worker', $code_worker)
                ->with('user')
                ->first();

            // Verificar si el trabajador existe y la contraseña es correcta
            if (!$worker || !Hash::check($request->password, $worker->user->password)) {
                return response()->json([
                    'status' => false,
                    'message' => 'Acceso denegado: Trabajador no encontrado o contraseña incorrecta.'
                ], 401);
            }

            // Autenticación exitosa, devolver los datos del trabajador
            return response()->json([
                'status' => true,
                'message' => 'Inicio de sesión exitoso.',
                'data' => [
                    'name' => $worker->nombre,
                    'last_name' => $worker->apellido,
                    'worker_id' => $worker->id,
                    'code_worker' => $worker->code_worker,
                    'user_id' => $worker->user->id,
                ],
            ]);
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
    public function loginUser(Request $request)
    {
        try {
            return response()->json([
                'status' => true,
                'message' => 'Hello Login User',
                'data' => [
                    $request->all()
                ]
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'An error occurred during login.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
