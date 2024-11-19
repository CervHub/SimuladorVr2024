<?php

namespace App\Http\Controllers\Models;

use App\Http\Controllers\Controller;
use App\Models\Workshop;
use Illuminate\Http\Request;
use App\Models\Induction;
use App\Models\WorkshopCompany;

class WorshopCompanyController extends Controller
{
    public function create(Request $request)
    {
        try {

            $existingRecord = WorkshopCompany::where('id_workshop', $request->id_workshop)
                ->where('id_company', $request->id_company)
                ->first();

            if ($existingRecord) {
                return false;
            }

            $workshopcompany = new WorkshopCompany();
            $workshopcompany->alias = $request->alias;
            $workshopcompany->id_workshop = $request->id_workshop;
            $workshopcompany->id_company = $request->id_company;
            $workshopcompany->status = '1';
            $workshopcompany->save();
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }
    public function edit(Request $request)
    {
        $workshopcompany = WorkshopCompany::find($request->id_workshop_company);

        try {
            // Actualizar el alias y otros campos de WorkshopCompany
            $workshopcompany->alias = $request->alias;
            $workshopcompany->status = $request->status;
            $workshopcompany->save();

            // Actualizar el alias de todas las inducciones
            Induction::where('id_workshop', $workshopcompany->id_workshop)
                ->where('id_company', $workshopcompany->id_company)
                ->update(['alias' => $request->alias]);

            return true;
        } catch (\Throwable $th) {
            dd($th);
            return false;
        }
    }
    public function detail($id)
    {
        return WorkshopCompany::find($id);
    }
}
