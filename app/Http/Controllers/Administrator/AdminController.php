<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Worker;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Models\UserController;
use Illuminate\Support\Facades\Session;
use App\Models\Company;
use App\Models\Step;
use App\Models\WorkshopCompany;
use Illuminate\Support\Facades\DB;

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
        $id_company = session('id_company');
        $workers = Worker::where('id_company', $id_company)->where('id_role', 3)->where('status', '1')->get();
        return view('Administrator.entrenador', compact('workers'));
    }
    public function crearentrenador(Request $request)
    {
        $id_company = session('id_company');
        $id_service = session('id_service');

        $estado = $this->userController->createInstructor($request, $id_company, $id_service);
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
            'last_name' => $requestData->apellido,
            'name' => $requestData->nombre,
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

    public function updateCompany(Request $request)
    {
        $company = Company::find(session('id_company'));

        $this->updateImage($request, 'desktopLogo', 'url_image_desktop', $company);
        $this->updateImage($request, 'mobileLogo', 'url_image_mobile', $company);
        $company->ponderado = $request->ponderado;
        $company->save();
        Session::flash('success', 'Se ha cargado exitosamente.');

        return redirect()->back();
    }

    private function updateImage($request, $inputName, $fieldName, $entity)
    {
        if ($request->hasFile($inputName)) {
            $oldImage = $entity->$fieldName;

            if ($oldImage) {
                $oldImagePath = public_path($oldImage);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            $newImage = $request->file($inputName);
            $uniqueFileName = 'logo_photo/' . time() . '_' . $inputName . '_' . uniqid() . '.' . $newImage->getClientOriginalExtension();
            $destinationPath = public_path('logo_photo');

            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            $newImage->move($destinationPath, $uniqueFileName);
            $entity->$fieldName = $uniqueFileName;
        }
    }

    public function updatecolormobile(Request $request)
    {
        // Valida y guarda el color para dispositivos móviles en la base de datos
        $color = $request->color;
        $company = Company::find(session('id_company'));
        $company->mobile = $color;
        $company->save();

        // Puedes enviar una respuesta JSON si lo deseas
        return response()->json(['message' => 'Color para dispositivos móviles actualizado correctamente']);
    }

    public function updatecolordesktop(Request $request)
    {
        // Valida y guarda el color para dispositivos de escritorio en la base de datos
        $color = $request->color;
        $company = Company::find(session('id_company'));
        $company->desktop = $color;
        $company->save();

        // Puedes enviar una respuesta JSON si lo deseas
        return response()->json(['message' => 'Color para dispositivos de escritorio actualizado correctamente']);
    }

    public function talleres(Request $request)
    {

        $workshop_companies = WorkshopCompany::where('id_company', session('id_company'))->get();
        $id_company = session('id_company');
        $workers = Worker::where('id_company', $id_company)->where('id_role', 3)->where('status', '1')->get();
        return view('Administrator.tallernotas', compact('workers', 'workshop_companies'));
    }

    public function updateTalleres(Request $request)
    {
        $values = $request->input('values');

        DB::beginTransaction();

        try {
            foreach ($values as $value) {
                WorkshopCompany::where('id', $value['id'])->update([
                    'pondered_note' => $value['pondered_note'],
                    'minimum_passing_note' => $value['minimum_passing_note']
                ]);
            }

            DB::commit();

            return response()->json(['message' => 'Conexión exitosa'], 200);
        } catch (\Exception $e) {
            DB::rollback();

            // Aquí puedes manejar el error como quieras
            return response()->json(['message' => 'Ocurrió un error al actualizar los datos'], 500);
        }
    }

    public function steps()
    {
        $id_company = session('id_company');
        $workshops = WorkshopCompany::where('id_company', $id_company)->get();

        $steps = $workshops->map(function ($workshop) {
            return [
                'name' => $workshop->alias,
                'steps' => $workshop->workshop->steps->map(function ($step) {
                    return [
                        'id' => $step->id,
                        'name' => $step->name,
                        'duration' => $step->duration
                    ];
                })
            ];
        });

        return view('Administrator.steps', compact('steps'));
    }

    public function updateSteps(Request $request)
    {
        $steps = $request->input('steps');

        foreach ($steps as $step) {
            // Assuming you have a Step model and the id and duration fields
            $stepModel = Step::find($step['id']);
            if ($stepModel) {
                $stepModel->duration = $step['duration'];
                $stepModel->save();
            }
        }

        return response()->json([
            'message' => 'Pasos actualizados correctamente',
            'data' => $steps
        ], 200);
    }
}
