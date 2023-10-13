<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Worker;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Models\UserController;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{

    protected $userController;

    public function __construct(UserController $userController)
    {
        $this->userController = $userController;
    }

    public function index()
    {
        return view('Administrator.index');
    }
    public function servicio()
    {
        return view('Administrator.servicio');
    }
    public function reporte()
    {
        return view('Administrator.reporte');
    }
    
    public function entrenador()
    {
        $id_company = Auth::user()->workers[0]->id_company;
        $workers = Worker::where('id_company', $id_company)->where('id_role', 3)->get();
        return view('Administrator.entrenador', compact('workers'));
    }
    public function crearentrenador(Request $request)
    {
        $id_company = Auth::user()->workers[0]->id_company;
        $id_service = Auth::user()->workers[0]->id_service;

        $estado = $this->userController->create($request, $id_company, $id_service);
        if ($estado) {
            // Creación exitosa
            Session::flash('success', 'La Creacion se ha realizado exitosamente.');
        }
        return redirect()->back();
    }
    public function editarentrenador(Request $request)
    {
        $estado = $this->userController->editar($request);
        if ($estado) {
            // Creación exitosa
            Session::flash('success', 'Se ha actualizado los datos exitosamente.');
        }
        return redirect()->back();
    }
    public function detalle(Request $request)
    {
        // Crear un arreglo asociativo con los datos que deseas incluir en el JSON
        $requestData = $this->userController->detalle($request->id);

        $responseData = [
            'id' => $requestData->id,
            'last_name' => $requestData->user->last_name,
            'name' => $requestData->user->name,
            'position' => $requestData->position,
            'doi' => $requestData->user->doi,
            'worker' => $requestData,
        ];

        // Responder con el arreglo en formato JSON
        return response()->json($responseData);
        // Obtener todos los datos del Request
    }

    public function deletearentrenador(Request $request)
    {
        $estado = $this->userController->eliminar($request);
        if ($estado) {
            // Creación exitosa
            Session::flash('success', 'Se ha eliminado al entrenador exitosamente.');
        }
        return redirect()->back();
    }
}
