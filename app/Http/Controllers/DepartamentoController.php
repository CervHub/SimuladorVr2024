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

    public function areas(Request $request, $id)
    {
        $areas = Area::where('departamento_id', '=', $id)->get();
        $department_id = $id;
        return view('Administrator.Departamento.areas', compact('areas', 'department_id'));
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
