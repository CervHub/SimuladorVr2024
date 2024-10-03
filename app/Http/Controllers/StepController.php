<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Step;
use Exception;
use Session;

class StepController extends Controller
{
    public function createstep(Request $request, $workshop_id)
    {
        try {
            $new = new Step();
            $new->name = $request->name;
            $new->duration = $request->duration;
            $new->workshop_id = $workshop_id;
            $new->save();

            Session::flash('success', 'El paso se ha creado exitosamente.');
        } catch (Exception $e) {
            Session::flash('error', 'Hubo un error al crear el paso: ' . $e->getMessage());
        }

        return redirect()->back();
    }

    public function editstep(Request $request, $step_id)
    {
        try {
            $step = Step::find($step_id);
            $step->name = $request->name;
            $step->duration = $request->duration;
            $step->save();

            Session::flash('success', 'El paso se ha actualizado exitosamente.');
        } catch (Exception $e) {
            Session::flash('error', 'Hubo un error al actualizar el paso: ' . $e->getMessage());
        }

        return redirect()->back();
    }

    public function deletestep(Request $request, $step_id)
    {
        try {
            $step = Step::find($step_id);
            $step->delete();

            Session::flash('success', 'El paso se ha eliminado exitosamente.');
        } catch (Exception $e) {
            Session::flash('error', 'Hubo un error al eliminar el paso: ' . $e->getMessage());
        }

        return redirect()->back();
    }
}
