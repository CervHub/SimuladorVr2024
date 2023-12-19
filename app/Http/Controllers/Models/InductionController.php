<?php

namespace App\Http\Controllers\Models;

use App\Http\Controllers\Controller;
use App\Models\Induction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Company;
use App\Models\WorkshopCompany;


class InductionController extends Controller
{
    public function create(Request $request)
    {
        $company = Company::find(session('id_company'));
        $notas = WorkshopCompany::where('id_company',$company->id)->where('id_workshop',$request->course)->first();
        try {
            $induction = Induction::create([
                'date_start' => $request->start_date,
                'date_end' => $request->end_date,
                'time_start' => $request->start_time,
                'time_end' => $request->end_time,
                'id_workshop' => $request->course,
                'id_company' => session('id_company'),
                'nota_referencial' => $company->ponderado,
                'intentos' => $request->intentos,
                'status' => '1',
                'id_worker' => session('id_worker'),
                'alias' => $request->alias,
                'pondered_note' => $notas->pondered_note,
                'minimum_passing_note' => $notas->minimum_passing_note,
            ]);

            return true;
        } catch (\Throwable $th) {
            // Volcar y terminar el script para ver el error


            Session::flash('error', 'Hubo un error al crear la inducción.');
            return false;
        }
    }


    public function search(Request $request)
    {
        return Induction::find($request->id);
    }

    public function update(Request $request)
    {
        try {
            $induction = Induction::find($request->id_induction);
            $induction->date_start = $request->start_date;
            $induction->date_end = $request->end_date;
            $induction->time_start = $request->start_time;
            $induction->time_end = $request->end_time;
            $induction->status = $request->status;
            $induction->intentos = $request->intentos;
            $induction->save();
            return true;
        } catch (\Throwable $th) {
            Session::flash('error', 'Hubo un error al actualizar la induccion.');
            return false;
        }
    }
}
