<?php

namespace App\Http\Controllers\Models;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service;
use Illuminate\Support\Str; // Importa la clase Str para generar contraseñas únicas
use Illuminate\Support\Facades\Session;

class ServiceController extends Controller
{
    public function create(Request $request, $id)
    {
        try {
            // Verificar si ya existe un servicio con el mismo RUC
            $existingService = Service::where('ruc', $request->ruc)->where('id_company', session('id_company'))->first();
            if ($existingService) {
                if ($existingService->status == '0') {
                    $existingService->status = '1';
                    $existingService->save();
                    return true;
                } else {
                    Session::flash('error', 'Ya existe un servicio con el mismo RUC.');
                    return false;
                }
            } else {
                // Crear un nuevo servicio solo si no existe uno con el mismo RUC
                $new_service = new Service();
                $new_service->name = $request->name;
                $new_service->description = $request->description;
                $new_service->ruc = $request->ruc;
                $new_service->id_company = $id;
                $new_service->status = '1';
                $new_service->save();
                return true;
            }
        } catch (\Illuminate\Database\QueryException $ex) {
            // Manejar la excepción específica de QueryException
            Session::flash('error', 'Hubo un error en la consulta de base de datos.');
            return false;
        } catch (\Throwable $th) {
            // Manejar otras excepciones
            Session::flash('error', 'Ocurrió un error.');
            return false;
        }
    }

    public function edit(Request $request)
    {
        try {

            $service = Service::find($request->id_service);
            $service->name = $request->name;
            $service->description = $request->description;
            $service->save();
            return true;
        } catch (\Throwable $th) {
            Session::flash('error', 'Ocurrió un error.');
            return false;
        }
    }
    public function delete(Request $request)
    {
        try {
            $eliminar = Service::find($request->id_service);
            $eliminar->status = '0';
            $eliminar->save();
            return true;
        } catch (\Throwable $th) {
            Session::flash('error', 'No se puso eliminar.');
            return false;
        }
    }

    public function detail($id)
    {
        $data = Service::find($id);
        return $data;
    }
}
