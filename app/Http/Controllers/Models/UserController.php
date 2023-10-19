<?php

namespace App\Http\Controllers\Models;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Worker;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str; // Importa la clase Str para generar contraseñas únicas

class UserController extends Controller
{
    public function create(Request $request, $id_company, $id_service)
    {
        //Usuario Para Empresa
        // Generar correo basado en el nombre y convertir a minúsculas
        $correo = Str::lower(str_replace(' ', '', $request->doi)) . '@cerv.com';
        $exists_user = true;


        //Validamos el usuario para no crearlo de nuevo y de error.
        $user = User::where('doi', $request->doi)->first();
        if ($user) {
            $exists_user = false;
            //Validamos que no exista un trabajador asociado a ese usario en rol entrenador o supervisor
            dd($worker);
            if ($worker) {
                Session::flash('error', 'El Usuario ya existe.');
                return false;
            }
        }

        try {

            $password = Str::random(12); // Genera una cadena aleatoria de 12 caracteres

            // Nuevo Entrenador
            if ($exists_user) {
                $user = new User();
                $user->name = $request->name;
                $user->last_name = $request->last_name;
                $user->status = '1';
                $user->doi = $request->doi;
                $user->email = $correo;
                $user->password = bcrypt($password); // Encripta la contraseña
                $user->password_text = $password;
                $user->save();
            }


            // Asociamos su cuenta de trabajador al entrenador
            //Crear Trabajador por defaul en modo administrador
            $codeWorker = sprintf("%03d-%03d-%s", 300, $id_company, $request->doi);
            $new_worker = new Worker();
            $new_worker->id_role = 3;
            $new_worker->id_user = $user->id;
            $new_worker->id_company = $id_company;
            $new_worker->id_service = $id_service;
            $new_worker->position = $request->position;
            $new_worker->status = '1';
            $new_worker->code_worker = $codeWorker;
            $new_worker->save();

            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }
    public function createInstructor(Request $request, $id_company, $id_service)
    {
        //Usuario Para Empresa
        // Generar correo basado en el nombre y convertir a minúsculas
        $correo = Str::lower(str_replace(' ', '', $request->doi)) . '@cerv.com';
        $exists_user = true;


        //Validamos el usuario para no crearlo de nuevo y de error.
        $user = User::where('doi', $request->doi)->first();
        if ($user) {
            $exists_user = false;
            //Validamos que no exista un trabajador asociado a ese usario en rol entrenador o supervisor
            $worker = Worker::where('id_role', 3)->where('id_user', $user->id)->where('id_company', $id_company)->first();
            if ($worker) {
                if ($worker->status == '0') {
                    $worker->status = '1';
                    $worker->save();
                    Session::flash('success', 'El Usuario ya existia y se activo.');
                    return false;
                }
                Session::flash('error', 'El Usuario ya existe.');
                return false;
            }
        }

        try {

            $password = Str::random(12); // Genera una cadena aleatoria de 12 caracteres

            // Nuevo Entrenador
            if ($exists_user) {
                $user = new User();
                $user->name = $request->name;
                $user->last_name = $request->last_name;
                $user->status = '1';
                $user->doi = $request->doi;
                $user->email = $correo;
                $user->password = bcrypt($password); // Encripta la contraseña
                $user->password_text = $password;
                $user->save();
            }


            // Asociamos su cuenta de trabajador al entrenador
            //Crear Trabajador por defaul en modo administrador
            $codeWorker = sprintf("%03d-%03d-%s", 300, $id_company, $request->doi);
            $new_worker = new Worker();
            $new_worker->id_role = 3;
            $new_worker->id_user = $user->id;
            $new_worker->id_company = $id_company;
            $new_worker->nombre = $request->name;
            $new_worker->apellido = $request->last_name;
            $new_worker->id_service = $id_service;
            $new_worker->position = $request->position;
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
        $data = Worker::find($id);
        return $data;
    }
    public function editar(Request $request)
    {
        try {
            $worker = Worker::find($request->id_worker);
            $worker->position = $request->position;
            
            $worker->nombre = $request->name;
            $worker->apellido = $request->last_name;
            $worker->save();

            return true;
        } catch (\Throwable $th) {
            Session::flash('error', 'Ocurrio algo inesperado al actualizar los datos.');

            return false;
        }
    }
    public function eliminar(Request $request)
    {
        try {
            $eliminar = Worker::find($request->id_worker);
            $eliminar->status = '0';
            $eliminar->save();
            return true;
        } catch (\Throwable $th) {
            Session::flash('error', 'No se puso eliminar.');
            return false;
        }
    }

    public function createTrabajador(Request $request, $id_company)
    {
        //Usuario Para EServicio
        // Generar correo basado en el nombre y convertir a minúsculas
        $correo = Str::lower(str_replace(' ', '', $request->doi)) . '@cerv.com';
        $exists_user = true;


        //Validamos el usuario para no crearlo de nuevo y de error.
        $user = User::where('doi', $request->doi)->first();
        if ($user) {
            $exists_user = false;
            //Validamos que no exista un trabajador asociado a ese usario en rol estudiante

            $worker = Worker::where('id_role', 4)->where('id_user', $user->id)->where('id_company', $id_company)->where('id_service', $request->id_service)->first();
            if ($worker) {
                Session::flash('error', 'El Usuario ya existe.');
                return false;
            }
        }

        try {

            // Nuevo Entrenador
            if ($exists_user) {
                $user = new User();
                $user->name = $request->name;
                $user->last_name = $request->last_name;
                $user->status = '1';
                $user->doi = $request->doi;
                $user->email = $correo;
                $user->password = bcrypt($request->doi); // Encripta la contraseña
                $user->password_text = $request->doi;
                $user->save();
            }


            // Asociamos su cuenta de trabajador al entrenador
            //Crear Trabajador por defaul en modo administrador
            $codeWorker = sprintf("%03d-%03d-%05d-%s", 400, $id_company, $request->id_service, $request->doi);
            $new_worker = new Worker();
            $new_worker->id_role = 4;
            $new_worker->id_user = $user->id;
            $new_worker->id_company = $id_company;
            $new_worker->id_service = $request->id_service;
            $new_worker->position = $request->position;
            $new_worker->status = '1';
            $new_worker->code_worker = $codeWorker;
            $new_worker->save();

            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }

    public function createTrabajadorMasivo($name, $last_name, $doi, $position, $id_service, $id_company)
    {
        //Usuario Para EServicio
        // Generar correo basado en el nombre y convertir a minúsculas
        $correo = Str::lower(str_replace(' ', '', $doi)) . '@cerv.com';
        $exists_user = true;


        //Validamos el usuario para no crearlo de nuevo y de error.
        $user = User::where('doi', $doi)->first();
        if ($user) {
            $exists_user = false;
            //Validamos que no exista un trabajador asociado a ese usario en rol estudiante

            $worker = Worker::where('id_role', 4)->where('id_user', $user->id)->where('id_service', $id_service)->first();
            if ($worker) {
                if ($worker->status == '0') {
                    $worker->status = '1';
                    return false;
                }
                return false;
            }
        }

        try {

            // Nuevo Entrenador
            if ($exists_user) {
                $user = new User();
                $user->name = $name;
                $user->last_name = $last_name;
                $user->status = '1';
                $user->doi = $doi;
                $user->email = $correo;
                $user->password = bcrypt($doi); // Encripta la contraseña
                $user->password_text = $doi;
                $user->save();
            }


            // Asociamos su cuenta de trabajador al entrenador
            //Crear Trabajador por defaul en modo administrador
            $codeWorker = sprintf("%03d-%03d-%05d-%s", 400, $id_company, $id_service, $doi);
            $new_worker = new Worker();
            $new_worker->id_role = 4;
            $new_worker->id_user = $user->id;
            $new_worker->id_company = $id_company;
            $new_worker->id_service = $id_service;
            $new_worker->position = $position;
            $new_worker->nombre = $name;
            $new_worker->apellido = $last_name;
            $new_worker->status = '1';
            $new_worker->code_worker = $codeWorker;
            $new_worker->save();

            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }
}
