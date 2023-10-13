<?php

namespace App\Http\Controllers\Models;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\Workshop;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str; // Importa la clase Str para generar contraseñas únicas

class WorkshopController extends Controller
{
    public function create(Request $request)
    {
        try {
            $new_company = new Workshop();
            $new_company->name = $request->name;
            $new_company->description = $request->description;
            $new_company->status = '1';
            $new_company->save();
            return true;
        } catch (\Throwable $th) {
            //throw $th;
            Session::flash('error', 'Hubo un error al crearlo.');
            return false;
        }
    }
    public function edit(Request $request)
    {
        
        try {
            $workshop = Workshop::find($request->id_workshop);
            $workshop->name = $request->name;
            $workshop->description = $request->description;
            $workshop->status = $request->status;
            $workshop->save();
            return true;
        } catch (\Throwable $th) {
            //throw $th;
            Session::flash('error', 'Hubo un error al actualizarlo.');
            return false;
        }
    }
    public function details($id)
    {
        return Workshop::find($id);
    }
}
