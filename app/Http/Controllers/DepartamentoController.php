<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Area;
use App\Models\Departamento;
use Illuminate\Support\Facades\Session;

class DepartamentoController extends Controller
{
    public function departamento(Request $request)
    {
        $departamentos = Departamento::all();
        return view('Administrator.Departamento.index', compact('departamentos'));
    }


    public function store(Request $request)
    {
        try {
            // Verificar si el departamento ya existe para la compañía
            $existingDepartment = Departamento::where('name', $request->name)
                ->where('company_id', Session::get('id_company'))
                ->first();

            if ($existingDepartment) {
                // Mensaje flash
                Session::flash('error', 'El nombre del departamento ya existe para esta compañía.');

                // Redirigir al usuario
                return redirect()->back();
            }

            // Crear un nuevo departamento
            $departamento = Departamento::create([
                'name' => $request->name,
                'company_id' => Session::get('id_company')
            ]);

            // Mensaje flash
            Session::flash('success', 'Departamento creado con éxito.');

            // Redirigir al usuario
            return redirect()->route('departamentos');
        } catch (\Exception $e) {

            // Mensaje flash
            Session::flash('error', 'Ocurrió un error al crear el departamento.');

            // Redirigir al usuario
            return redirect()->back();
        }
    }

    public function search(Request $request)
    {
        $data = Departamento::find($request->id);
        $responseData = [
            'id' => $data->id,
            'name' => $data->name
        ];

        // Responder con el arreglo en formato JSON
        return response()->json($responseData);
    }
    public function areasearch(Request $request)
    {
        $data = Area::find($request->id);
        $responseData = [
            'id' => $data->id,
            'name' => $data->name
        ];

        // Responder con el arreglo en formato JSON
        return response()->json($responseData);
    }
    public function areas(Request $request, $id)
    {
        $areas = Area::where('departamento_id', '=', $id)->get();
        $department_id = $id;
        return view('Administrator.Departamento.areas', compact('areas', 'department_id'));
    }

    public function edit(Request $request)
    {
        try {
            // Encuentra el departamento por su ID
            $departamento = Departamento::find($request->id);

            if (!$departamento) {
                // Maneja la situación donde el departamento no se encuentra
                Session::flash('error', 'Departamento no encontrado');
                return redirect()->back();
            }

            // Actualiza el nombre del departamento con el valor recibido en 'name'
            $departamento->name = $request->name;

            // Guarda los cambios
            $departamento->save();

            // Redirige de nuevo con un mensaje flash de éxito
            Session::flash('success', 'Departamento actualizado correctamente');
            return redirect()->back();
        } catch (\Exception $e) {
            // Maneja cualquier excepción que pueda ocurrir durante el proceso de actualización
            Session::flash('error', 'Error al actualizar el departamento');
            return redirect()->back();
        }
    }

    public function areaedit(Request $request)
    {
        try {
            // Encuentra el departamento por su ID
            $departamento = Area::find($request->id);

            if (!$departamento) {
                // Maneja la situación donde el departamento no se encuentra
                Session::flash('error', 'Departamento no encontrado');
                return redirect()->back();
            }

            // Actualiza el nombre del departamento con el valor recibido en 'name'
            $departamento->name = $request->name;

            // Guarda los cambios
            $departamento->save();

            // Redirige de nuevo con un mensaje flash de éxito
            Session::flash('success', 'Departamento actualizado correctamente');
            return redirect()->back();
        } catch (\Exception $e) {
            // Maneja cualquier excepción que pueda ocurrir durante el proceso de actualización
            Session::flash('error', 'Error al actualizar el departamento');
            return redirect()->back();
        }
    }

    public function agregarArea(Request $request)
    {
        try {
            $areaExistente = Area::where('name', $request->name)
                ->where('departamento_id', $request->department_id)
                ->first();

            if ($areaExistente) {
                return redirect()->back()->with('error', 'El nombre del área ya existe en este departamento');
            }

            $area = Area::create([
                'name' => $request->name,
                'departamento_id' => $request->department_id,
            ]);

            return redirect()->back()->with('success', 'Área creada con éxito');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Hubo un error al crear la área: ' . $e->getMessage());
        }
    }
    public function getAreas($id)
    {
        // Asegúrate de que tienes una relación definida en tu modelo Departamento
        $departamento = Departamento::find($id);
        $areas = $departamento->areas()->pluck('name', 'id');

        return response()->json($areas);
    }
}
