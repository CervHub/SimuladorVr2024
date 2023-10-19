<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Worker;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function perfil(Request $request)
    {

        $desiredCompanyId = Session::get('id_company');
        $role = Session::get('id_role');
        $foundWorker = null;

        $company = Company::find($desiredCompanyId);

        foreach (Auth::user()->workers as $worker) {
            if ($worker->id_company === $desiredCompanyId) {
                $foundWorker = $worker;
                break; // Terminamos el bucle cuando encontramos una coincidencia
            }
        }
        if ($role == 1) {
            return view('SuperAdmin.perfil', compact('foundWorker'));
        } elseif ($role == 2) {
            return view('Administrator.perfil', compact('foundWorker', 'company'));
        } elseif ($role == 3) {
            return view('Supervisor.perfil', compact('foundWorker'));
        }
    }
    public function update(Request $request)
    {
        // Obtener el usuario y trabajador que deseas actualizar
        $user = User::find($request->id_user);
        $worker = Worker::find($request->id_worker);

        // Verificar si el usuario y el trabajador existen
        if (!$user || !$worker) {
            return redirect()->back()->with('error', 'Usuario o trabajador no encontrado');
        }

        // Actualizar los campos del usuario y el trabajador si están presentes en la solicitud
        if ($request->filled('firstName')) {
            $worker->nombre = $request->firstName;
        }
        if ($request->filled('lastName')) {
            $worker->apellido = $request->lastName;
        }
        if ($request->filled('jobTitle')) {
            $worker->position = $request->jobTitle;
        }
        // Guardar cambios en el trabajador
        $worker->save();
        // Guardar la imagen de perfil si se ha cargado
        if ($request->hasFile('profilePicture')) {
            $profilePicture = $request->file('profilePicture');
            $uniqueFileName = time() . '_' . uniqid() . '.' . $profilePicture->getClientOriginalExtension();
            $destinationPath = public_path('photoperfil');
            $profilePicture->move($destinationPath, $uniqueFileName);
            $user->photo = 'photoperfil/' . $uniqueFileName;
        }

        // Guardar cambios en el usuario
        $user->save();

        return redirect()->back()->with('success', 'Usuario y trabajador actualizados exitosamente');
    }
    public function updatepassword(Request $request)
    {


        // Obtener el usuario actual
        $user = User::find($request->id_user);

        // Verificar si la contraseña antigua es correcta
        if (!Hash::check($request->oldPassword, $user->password)) {
            return redirect()->back()->with('error', 'La contraseña antigua es incorrecta');
        }

        // Actualizar la contraseña del usuario con la nueva contraseña
        $user->password = Hash::make($request->newPassword);
        $user->save();

        return redirect()->back()->with('success', 'Contraseña actualizada exitosamente');
    }
}
