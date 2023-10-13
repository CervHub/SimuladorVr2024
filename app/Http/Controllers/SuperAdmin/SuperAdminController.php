<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Company;
use App\Http\Controllers\Models\CompanyController;
use App\Http\Controllers\Models\WorkshopController;
use App\Http\Controllers\Models\WorshopCompanyController;
use Illuminate\Support\Facades\Session;
use App\Models\Workshop;
use App\Models\WorkshopCompany;

class SuperAdminController extends Controller
{

    protected $companyController;
    protected $workshopController;
    protected $workshopcompanyController;

    public function __construct(CompanyController $companyController, WorkshopController $workshopController, WorshopCompanyController $workshopcompanyController)
    {
        $this->companyController = $companyController;
        $this->workshopController = $workshopController;
        $this->workshopcompanyController = $workshopcompanyController;
    }

    public function index(Request $request)
    {
        return view('SuperAdmin.index');
    }

    public function empresa(Request $request)
    {
        $companies = Company::all(); // Traemos todas las empresas
        return view('SuperAdmin.empresas', compact('companies'));
    }

    public function reporte(Request $request)
    {
        return view('SuperAdmin.reporte');
    }

    public function tallercompany(Request $request, $id_company)
    {
        $workshopcompanies = WorkshopCompany::where('id_company', $id_company)->get();
        $company = Company::find($id_company);
        $workshops = Workshop::all();
        return view('SuperAdmin.taller.main', compact('id_company', 'company', 'workshopcompanies', 'workshops'));
    }

    public function createtaller(Request $request)
    {

        $estado = $this->workshopController->create($request);
        if ($estado) {
            // Creación exitosa
            Session::flash('success', 'La creación se ha realizado exitosamente.');
        }
        return redirect()->back();
    }

    public function detailstalleres(Request $request)
    {
        // Crear un arreglo asociativo con los datos que deseas incluir en el JSON
        $requestData = $this->workshopController->details($request->id);

        $responseData = [
            'id' => $requestData->id,
            'name' => $requestData->name,
            'description' => $requestData->description,
            'status' => $requestData->status,
        ];

        // Responder con el arreglo en formato JSON
        return response()->json($responseData);
        // Obtener todos los datos del Request
    }

    public function detailstalleres2(Request $request)
    {
        // Crear un arreglo asociativo con los datos que deseas incluir en el JSON
        $requestData = $this->workshopcompanyController->detail($request->id);

        $responseData = [
            'id' => $requestData->id,
            'alias' => $requestData->alias,
            'id_workshop' => $requestData->id_workshop,
            'status' => $requestData->status,
        ];

        // Responder con el arreglo en formato JSON
        return response()->json($responseData);
        // Obtener todos los datos del Request
    }

    public function editartaller(Request $request)
    {
        $estado = $this->workshopController->edit($request);
        if ($estado) {
            // Creación exitosa
            Session::flash('success', 'La actualizacion se ha realizado exitosamente.');
        }

        return redirect()->back();
    }

    public function editartallercompany(Request $request)
    {
        $estado = $this->workshopcompanyController->edit($request);
        if ($estado) {
            Session::flash('success', 'La actualizacion se ha realizado exitosamente.');
        } else {
            Session::flash('error', 'Ocurrio un error.');
        }
        return redirect()->back();
    }

    public function dashboardtalleres(Request $request)
    {
        $workshops = Workshop::all();
        return view('SuperAdmin.Taller.dashboard', compact('workshops'));
    }

    public function createtallercompanies(Request $request)
    {
        $estado = $this->workshopcompanyController->create($request);
        if ($estado) {
            Session::flash('success', 'La creación se ha realizado exitosamente.');
        } else {
            Session::flash('error', 'Ocurrio un error.');
        }
        return redirect()->back();
    }

    public function createCompany(Request $request)
    {
        $estado = $this->companyController->create($request);
        if ($estado) {
            // Creación exitosa
            Session::flash('success', 'La creación se ha realizado exitosamente.');
        }

        return redirect()->back();
    }

    public function details(Request $request)
    {
        // Crear un arreglo asociativo con los datos que deseas incluir en el JSON
        $requestData = $this->companyController->detalle($request->id);

        $responseData = [
            'id' => $requestData->id,
            'nombre' => $requestData->name,
            'ruc' => $requestData->ruc,
            'descripcion' => $requestData->description,
            'trabajadores' => $requestData->workers[0],
            'usuario' => $requestData->workers[0]->user,
            'status' => $requestData->status,
        ];

        // Responder con el arreglo en formato JSON
        return response()->json($responseData);
        // Obtener todos los datos del Request
    }

    public function editarcompany(Request $request)
    {
        $estado = $this->companyController->editar($request);
        if ($estado) {
            // Creación exitosa
            Session::flash('success', 'La actualización se ha realizado exitosamente.');
        }
        return redirect()->back();
    }

    public function eliminar(Request $request)
    {
        $estado = $this->companyController->delete($request);
        if ($estado) {
            // Creación exitosa
            Session::flash('success', 'La Eliminacion se ha realizado exitosamente.');
        }
        return redirect()->back();
    }
}
