<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Session;

use App\Models\Worker;
use Illuminate\Support\Facades\Redirect;

use function PHPSTORM_META\type;

class AuthenticationController extends Controller
{
    public function loginSubmit(Request $request)
    {
        $worker = Worker::where('code_worker', $request->code_worker)->first();

        if ($worker) {

            $credentials = [
                'email' => $worker->user->email,
                'password' => $request->password,
            ];

            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();
                Session::put('id_company', $worker->id_company);
                Session::put('id_worker', $worker->id);
                Session::put('id_role', $worker->id_role);
                Session::put('logo_desktop', $worker->company->url_image_desktop);
                Session::put('logo_mobile', $worker->company->url_image_mobile);
                Session::put('sidebar', $worker->company->mobile);
                Session::put('header', $worker->company->desktop);
                $type_user = $worker->id_role;
                if ($type_user == 1) {
                    return redirect()->route('superadministrador');
                } else if ($type_user == 2) {
                    return redirect()->route('administrador');
                } else if ($type_user == 3) {
                    return redirect()->route('entrenador');
                } else if ($type_user == 4) {
                    return redirect()->route('user');
                } else {
                    return redirect()->back();
                }
            } else {
                Session::flash('error', 'Credenciales incorrectas');
            }
        } else {
            Session::flash('error', 'No se encontró el trabajador');
        }

        return redirect()->back();
    }
    public function logout()
    {
        Auth::logout();
        Session::flash('error', 'Usted Cerro sesión');
        return redirect()->route('home'); // Redirige a donde quieras después del cierre de sesión
    }
}
