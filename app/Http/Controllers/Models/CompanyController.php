<?php

namespace App\Http\Controllers\Models;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\Service;
use App\Models\User;
use Illuminate\Support\Str; // Importa la clase Str para generar contraseñas únicas
use App\Models\Worker;
use Illuminate\Support\Facades\Session;

class CompanyController extends Controller
{
    public function create(Request $request)
    {

        try {
            //Usuario Para Empresa
            // Generar correo basado en el nombre y convertir a minúsculas
            $correo = Str::lower(str_replace(' ', '', $request->name)) . '@cerv.com';

            if (User::where('email', $correo)->orWhere('doi', $request->ruc)->exists()) {
                Session::flash('error', 'El correo electrónico o el RUC ya existen.');
                return false;
            }

            //Empresa Principal
            $new_company = new Company();
            $new_company->name = $request->name;
            $new_company->description = $request->description;
            $new_company->ruc = $request->ruc;
            $new_company->status = '1';
            $new_company->save();

            // Servicio Principal de la empresa
            $new_service =  new Service();
            $new_service->name = $request->name;
            $new_service->description = $request->description;
            $new_service->ruc = $request->ruc;
            $new_service->status = '1';
            $new_service->id_company = $new_company->id;
            $new_service->save();

            // Generar una contraseña única
            $password = Str::random(12); // Genera una cadena aleatoria de 12 caracteres

            // Crear un nuevo usuario
            $new_user = new User();
            $new_user->name = $request->name;
            $new_user->last_name = $request->name;
            $new_user->doi = $request->ruc;
            $new_user->email = $correo;
            $new_user->password = bcrypt($password); // Encripta la contraseña
            $new_user->password_text = $password; // Encripta la contraseña
            $new_user->status = '1';
            $new_user->save();

            //Crear Trabajador por defaul en modo administrador
            $codeWorker = sprintf("%03d-%03d-%s", 200, $new_company->id, $request->ruc);
            $new_worker = new Worker();
            $new_worker->id_role = 2;
            $new_worker->id_user = $new_user->id;
            $new_worker->id_company = $new_company->id;
            $new_worker->id_service = $new_service->id;
            $new_worker->position = 'Administrador General';
            $new_worker->status = '1';
            $new_worker->code_worker = $codeWorker;
            $new_worker->save();

            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }

    public function detalle($id)
    {
        $data = Company::find($id);
        return $data;
    }

    public function editar(Request $request)
    {
        $correo = Str::lower(str_replace(' ', '', $request->name)) . '@cerv.com';
        $company = Company::find($request->id_company);
        if ($request->name != $company->name) {
            if (User::where('email', $correo)->exists()) {
                Session::flash('error', 'La Empresa Ya existe.');
                return false;
            }
        }

        try {
            //Empresa Principal
            $company->name = $request->name;
            $company->description = $request->description;
            $company->status = $request->status;
            $company->save();

            //Servicio Principal
            $service = Service::where('id_company', $company->id)->first();
            $service->name = $request->name;
            $service->description = $request->description;
            $service->status = $request->status;
            $service->save();

            //Usuario Principal
            $worker = Worker::where('id_company', $company->id)->first();
            $user = User::find($worker->id);
            $user->email = $correo;
            $user->status = $request->status;
            $user->save();


            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }
    public function delete(Request $request)
    {
        try {
            $eliminar = Company::find($request->id_company);
            $eliminar->status = '0';
            $eliminar->save();
            return true;
        } catch (\Throwable $th) {
            Session::flash('error', 'No se puso eliminar.');
            return false;
        }
    }
}
