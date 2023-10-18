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
            $workshop = new Workshop();
            $workshop->name = $request->name;
            $workshop->description = $request->description;
            $workshop->status = '1';

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $uniqueFileName = 'workshops/' . time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('workshops');

                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }

                $image->move($destinationPath, $uniqueFileName);
                $workshop->photo = $uniqueFileName;
            }

            $workshop->save();
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

            if (!$workshop) {
                // Manejar el caso en el que no se encuentra el taller
                return false;
            }

            $workshop->name = $request->name;
            $workshop->description = $request->description;
            $workshop->status = $request->status;

            if ($request->hasFile('image')) {
                // Obtener la foto anterior
                $oldPhoto = $workshop->photo;
                // Eliminar la foto anterior si existe
                if ($oldPhoto) {
                    $oldPhotoPath = public_path($oldPhoto);
                    if (file_exists($oldPhotoPath)) {
                        unlink($oldPhotoPath);
                    }
                }


                // Guardar la nueva foto
                $image = $request->file('image');
                $uniqueFileName = 'workshops/' . time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('workshops');

                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }

                $image->move($destinationPath, $uniqueFileName);
                $workshop->photo = $uniqueFileName;
            }

            $workshop->save();

            return true;
        } catch (\Throwable $th) {
            // Manejar la excepción en caso de error
            Session::flash('error', 'Hubo un error al actualizarlo.');
            return false;
        }
    }

    public function details($id)
    {
        return Workshop::find($id);
    }
}
