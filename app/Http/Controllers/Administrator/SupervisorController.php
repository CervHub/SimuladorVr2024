<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Models\ServiceController;
use App\Http\Controllers\Models\UserController;
use App\Http\Controllers\Models\InductionController;
use App\Models\DetailInductionWorker;
use App\Models\Induction;
use Illuminate\Support\Facades\Session;
use App\Models\Service;
use App\Models\Worker;
use App\Models\Workshop;
use App\Models\WorkshopCompany;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\InductionWorker;
use Dompdf\Dompdf;
use PDF; // Importar el facade de PDF
use App\Exports\InductionExcelReportExport;
use App\Models\Company;
use App\Models\User;
use Illuminate\Support\Carbon;

class SupervisorController extends Controller
{
    protected $serviceController;
    protected $userController;
    protected $inductionController;

    public function __construct(ServiceController $serviceController, UserController $userController, InductionController $inductionController)
    {
        $this->serviceController = $serviceController;
        $this->userController = $userController;
        $this->inductionController = $inductionController;
    }


    public function index(Request $request)
    {
        return view('Supervisor.index');
    }

    public function servicio(Request $request)
    {
        $id_company = session('id_company');
        $services = Service::where('id_company', $id_company)->where('status', 1)->get();
        return view('Supervisor.servicio', compact('services'));
    }

    public function reporte(Request $request)
    {
        $inductions = Induction::where('id_company', session('id_company'))
            ->orderBy('id', 'desc')
            ->get();
        $services = Service::where('id_company', session('id_company'))->get();
        return view('Supervisor.reporte', compact('inductions', 'services'));
    }
    public function crearservicio(Request $request)
    {
        $id_company = session('id_company');

        $estado = $this->serviceController->create($request, $id_company);
        if ($estado) {
            // Creación exitosa
            Session::flash('success', 'La Creacion se ha realizado exitosamente.');
        }
        return redirect()->back();
    }
    public function detalle(Request $request)
    {
        // Crear un arreglo asociativo con los datos que deseas incluir en el JSON
        $requestData = $this->serviceController->detail($request->id);

        $responseData = [
            'id' => $requestData->id,
            'name' => $requestData->name,
            'description' => $requestData->description,
            'ruc' => $requestData->ruc,
        ];

        // Responder con el arreglo en formato JSON
        return response()->json($responseData);
        // Obtener todos los datos del Request
    }
    public function editarservicio(Request $request)
    {
        $estado = $this->serviceController->edit($request);
        if ($estado) {
            // Creación exitosa
            Session::flash('success', 'Se actulizaron los datos exitosamente.');
        }
        return redirect()->back();
    }
    public function eliminararservicio(Request $request)
    {
        $estado = $this->serviceController->delete($request);
        if ($estado) {
            // Creación exitosa
            Session::flash('success', 'Se Elimino el Servicio exitosamente.');
        }
        return redirect()->back();
    }
    public function matricula(Request $request, $id_service)
    {
        $id_company = session('id_company');
        $nombre_service = Service::find($id_service)->name;
        $workers = Worker::where('id_company', $id_company)->where('id_service', $id_service)->where('status', '1')->get();

        return view('Supervisor.Matricula.matricula', compact('id_service', 'workers', 'nombre_service'));
    }

    public function crearuser(Request $request)
    {
        $id_company = session('id_company');
        $estado = $this->userController->createTrabajador($request, $id_company);
        if ($estado) {
            // Creación exitosa
            Session::flash('success', 'Se Creo exitosamente.');
        }
        return redirect()->back();
    }
    public function edituser(Request $request)
    {
        try {
            $worker = Worker::find($request->worker_id);

            if (!$worker) {
                // Trabajador no encontrado, lanzar una excepción
                throw new \Exception('Trabajador no encontrado');
            }

            // Actualizar los campos del trabajador
            $worker->nombre = $request->name;
            $worker->apellido = $request->last_name;

            $worker->save();

            // Éxito
            Session::flash('success', 'Se actualizó exitosamente: ' . $worker->nombre);
        } catch (\Exception $e) {
            // Error
            Session::flash('error', 'Error al actualizar el trabajador: ' . $e->getMessage());
        }

        return redirect()->back();
    }

    public function eliminarUser(Request $request)
    {
        try {
            $worker = Worker::find($request->worker_id);

            if (!$worker) {
                // Trabajador no encontrado, lanzar una excepción
                throw new \Exception('Trabajador no encontrado');
            }

            $workerName = $worker->nombre; // Almacena el nombre antes de eliminar

            $worker->status = '0'; // Eliminar el trabajador
            $worker->save();
            // Éxito
            Session::flash('success', 'Se eliminó exitosamente al trabajador: ' . $workerName);
        } catch (\Exception $e) {
            // Error
            Session::flash('error', 'Error al eliminar el trabajador: ' . $e->getMessage());
        }

        return redirect()->back();
    }


    public function cargamasiva(Request $request)
    {

        $id_company = session('id_company');
        // Verifica si se ha subido un archivo
        if ($request->hasFile('archivo_trabajadores')) {
            $archivo = $request->file('archivo_trabajadores');

            // Leer el archivo Excel y obtener los datos
            $datos = Excel::toArray([], $archivo);
            $filasConProblemas = []; // Almacenar filas con problemas
            $primerFila = true; // Bandera para omitir la primera fila (encabezado)

            // Iterar sobre las filas y ejecutar el método createTrabajadorMasivo
            foreach ($datos as $hoja) {
                foreach ($hoja as $fila) {
                    if ($primerFila) {
                        $primerFila = false; // Se marca la primera fila como leída (encabezado)
                        continue; // Se omite la primera fila (encabezado)
                    }

                    $result = $this->userController->createTrabajadorMasivo(
                        $fila[0],
                        $fila[1],
                        $fila[2],
                        $fila[3],
                        $request->id_service,
                        $id_company
                    );

                    if (!$result) {
                        $filasConProblemas[] = $fila; // Agregar fila a las que tienen problemas
                    }
                }
            }

            if (empty($filasConProblemas)) {
                // Todas las creaciones fueron exitosas
                Session::flash('success', 'Se crearon los trabajadores satisfactoriamente.');
            } else {
                // Algunas creaciones fallaron
                $errorString = 'Hubo problemas al crear trabajadores con los siguientes documento de identidad: ';

                $totalFilas = count($filasConProblemas);

                for ($i = 0; $i < $totalFilas; $i++) {
                    $errorString .= $filasConProblemas[$i][2];

                    if ($i < $totalFilas - 1) {
                        $errorString .= ', ';
                    } else {
                        $errorString .= '.';
                    }
                }

                Session::flash('error', $errorString);
            }
        } else {
            // Maneja el caso en que no se haya subido un archivo
            Session::flash('error', 'No se subió ningún archivo.');
        }
        return redirect()->back();
    }
    public function cargamasivainduction(Request $request)
    {
        try {
            $id_company = session('id_company');
            $id_induction = $request->id_induction;

            // Verifica si se ha subido un archivo
            if ($request->hasFile('archivo_trabajadores')) {
                $archivo = $request->file('archivo_trabajadores');

                // Leer el archivo Excel y obtener los datos
                $datos = Excel::toArray([], $archivo);
                $filasConProblemas = []; // Almacenar filas con problemas
                $filaActual = 1; // Iniciar desde la fila 2 (después del encabezado)

                // Iterar sobre las filas y ejecutar el método createTrabajadorMasivo
                $primerFila = true; // Bandera para omitir la primera fila (encabezado)

                foreach ($datos as $hoja) {
                    foreach ($hoja as $fila) {
                        if ($primerFila) {
                            $primerFila = false; // Se marca la primera fila como leída (encabezado)
                            continue; // Se omite la primera fila (encabezado)
                        }
                        $service = null;
                        $worker = null;

                        if ($fila[1]) {
                            $service = Service::where('name', $fila[1])->first();
                        }

                        if ($fila[0]) {
                            $worker = Worker::where('code_worker', 'LIKE', '%' . $fila[0] . '%')
                                ->where('id_company', session('id_company'))
                                ->where('id_service', optional($service)->id) // Use optional() to handle null service
                                ->first();
                        }

                        if (!$service) {
                            // Agregar esta fila al array de filas con problemas
                            $filasConProblemas[] = 'El servicio no existe para la fila ' . $filaActual;
                        }
                        if (!$worker) {
                            // Agregar esta fila al array de filas con problemas
                            $filasConProblemas[] = 'El trabajador no existe para la fila ' . $filaActual;
                        }

                        if ($worker) {
                            // Validar que no exista otro registro con la misma inducción y usuario
                            $existingRecord = InductionWorker::where('id_induction', $id_induction)
                                ->where('id_worker', $worker->id)
                                ->first();

                            if (!$existingRecord) {
                                $new_induction = new InductionWorker();
                                $new_induction->id_induction = $id_induction;
                                $new_induction->id_worker = $worker->id;
                                $new_induction->status = '1';
                                $new_induction->save();
                            } else {
                                if ($existingRecord->status == '0') {
                                    $existingRecord->status = '1';
                                    $existingRecord->save();
                                    $filasConProblemas[] = 'Se activo al trabajador de la fila ' . $filaActual;
                                } else {

                                    $filasConProblemas[] = 'Ya esta registrado el trabajador de la fila ' . $filaActual;
                                }
                            }
                        }

                        $filaActual++; // Incrementar el contador de fila
                    }
                }
            }

            if (count($filasConProblemas) > 0) {
                // Notificar errores en las filas con problemas
                $errorMessages = implode(', ', $filasConProblemas);
                Session::flash('error', 'Errores en las siguientes filas: ' . $errorMessages);
            } else {
                Session::flash('success', 'Se cargó exitosamente.');
            }
        } catch (\Exception $e) {
            Session::flash('error', 'Ocurrió un error: ' . $e->getMessage());
        }

        return redirect()->back();
    }
    public function induccion(Request $request)
    {
        $workshops = WorkshopCompany::where('id_company', session('id_company'))->get();
        $inductions = Induction::where('id_company', session('id_company'))
            ->where('status', '1')
            ->orderBy('id', 'desc')
            ->get();

        return view('Supervisor.Inducciones.main', compact('workshops', 'inductions'));
    }

    public function induccioneliminar(Request $request)
    {
        $induction = Induction::find($request->id_induction);
        // $workers = InductionWorker::where('id_induction', $induction->id)->get();

        // // Obtener los IDs de los workers
        // $workerIds = $workers->pluck('id');

        // // Eliminar los registros de DetailInductionWorker asociados a los workers
        // DetailInductionWorker::whereIn('induction_worker_id', $workerIds)->delete();

        // // Eliminar los workers
        // foreach ($workers as $worker) {
        //     $worker->delete();
        // }
        $induction->status = '0';
        $induction->save();
        // Aquí puedes realizar cualquier otra acción necesaria.

        return redirect()->back()->with('success', 'La simulación y sus detalles, trabajos y empleados asociados se han eliminado correctamente.');
    }


    public function induccioncreate(Request $request)
    {

        $estado = $this->inductionController->create($request);
        if ($estado) {
            Session::flash('success', 'Se Creo la induccion exitosamente.');
        }
        return redirect()->back();
    }

    public function induccionsearch(Request $request)
    {

        $requestData = $this->inductionController->search($request);

        $responseData = [
            'id' => $requestData->id,
            'id_workshop' => $requestData->id_workshop,
            'date_start' => $requestData->date_start,
            'date_end' => $requestData->date_end,
            'intentos' => $requestData->intentos,
            'time_start' => $requestData->time_start,
            'time_end' => $requestData->time_end,
            'status' => $requestData->status
        ];

        // Responder con el arreglo en formato JSON
        return response()->json($responseData);
    }

    public function induccionupdate(Request $request)
    {
        $estado = $this->inductionController->update($request);
        if ($estado) {
            Session::flash('success', 'Se actualizo exitosamente.');
        }
        return redirect()->back();
    }
    public function evaluacion(Request $request, $id_induction)
    {
        $inductionworkers = InductionWorker::where('id_induction', $id_induction)->where('status', '1')->get();
        $services = Company::find(session('id_company'))->services;
        $induction = Induction::find($id_induction);
        return view('Supervisor.InductionStudents.index', compact('id_induction', 'inductionworkers', 'services', 'induction'));
    }

    public function searchworker(Request $request)
    {
        $worker = Worker::where('code_worker', 'LIKE', '%' . '-' . $request->doi)
            ->where('id_company', session('id_company'))
            ->first();

        $responseData = [
            'id' => $worker->id,
            'position' => $worker->position,
            'name' => $worker->user->name,
            'last_name' => $worker->user->last_name,
            'id_induction' => $request->id_induction
        ];

        // Responder con el arreglo en formato JSON
        return response()->json($responseData);
    }

    public function searchworkerservice(Request $request)
    {
        try {
            $worker = Worker::where('code_worker', 'LIKE', '%' . '-' . $request->doi)
                ->where('id_company', session('id_company'))
                ->where('id_service', $request->id_service)
                ->first();

            if (!$worker) {
                throw new \Exception('Trabajador no encontrado');
            }

            $responseData = [
                'id' => $worker->id,
                'position' => $worker->position,
                'name' => $worker->user->name,
                'last_name' => $worker->user->last_name,
                'id_induction' => $request->id_induction,
            ];

            // Responder con el arreglo en formato JSON
            return response()->json($responseData);
        } catch (\Exception $e) {
            return response()->json("Error");
        }
    }


    public function searchworkerdoi(Request $request)
    {
        $worker = InductionWorker::find($request->id)->worker;

        $responseData = [
            'id' => $worker->id,
            'position' => $worker->position,
            'name' => $worker->user->name,
            'last_name' => $worker->user->last_name,
            'id_induction' => $request->id_induction
        ];

        // Responder con el arreglo en formato JSON
        return response()->json($responseData);
    }

    public function searchworkerdoiid(Request $request)
    {
        $worker = Worker::find($request->id);
        // Crear un arreglo con los datos que deseas retornar
        $data = [
            'id' => $worker->id,
            'name' => $worker->nombre,
            'last_name' => $worker->apellido,
            'position' => $worker->position,
            'dni' => $worker->user->doi,
        ];

        // Responder con el arreglo en formato JSON
        return response()->json($data);
    }


    public function inscribir(Request $request)
    {
        try {
            // Validar que no exista otro registro con la misma inducción y usuario
            $existingRecord = InductionWorker::where('id_induction', $request->id_induction)
                ->where('id_worker', $request->id_worker)
                ->first();

            if ($existingRecord) {
                if ($existingRecord->status == '0') {
                    $existingRecord->status = '1';
                    $existingRecord->save();
                    Session::flash('success', 'Se Inscribió Exitosamente.');
                    return redirect()->back();
                } else {
                    Session::flash('error', 'Ya existe un registro con esta inducción y usuario.');
                    return redirect()->back();
                }
            }

            $new_induction = new InductionWorker();
            $new_induction->id_induction = $request->id_induction;
            $new_induction->id_worker = $request->id_worker;
            $new_induction->status = '1';
            $new_induction->save();
            Session::flash('success', 'Se Inscribió Exitosamente.');
        } catch (\Throwable $th) {
            Session::flash('error', 'Ocurrió un error.');
        }
        return redirect()->back();
    }
    public function descargarinductionformato(Request $request)
    {
        $archivoPath = public_path('formatos/Formato Registro Masivo Induccion.xlsx');

        if (file_exists($archivoPath)) {
            return response()->download($archivoPath, 'archivo.xlsx');
        } else {
            abort(404, 'Archivo no encontrado');
        }
    }
    public function descargarmasivoformato(Request $request)
    {
        $archivoPath = public_path('formatos/Formato Carga Masiva.xlsx');

        if (file_exists($archivoPath)) {
            return response()->download($archivoPath, 'cargamasiva.xlsx');
        } else {
            abort(404, 'Archivo no encontrado');
        }
    }
    public function eliminarinductionworker(Request $request)
    {
        try {
            $inductionworker = InductionWorker::find($request->id);
            $inductionworker->status = '0';
            $inductionworker->save();
            Session::flash('success', 'Se Elimino Exitosamente.');
        } catch (\Throwable $th) {
            Session::flash('error', 'Ocurrió un error.');
        }
        return redirect()->back();
    }

    public function calcularPonderadoPorcentajeYCategoria($referenceNote, $note)
    {
        $ponderado = ($referenceNote != 0) ? (number_format($note, 0) / $referenceNote) * 20 : 0;

        $porcentaje = 0;
        $categoria = '';

        if ($ponderado >= 2 && $ponderado <= 6) {
            $porcentaje = 25;
            $categoria = 'Seguimiento';
        } elseif ($ponderado >= 7 && $ponderado <= 11) {
            $porcentaje = 59;
            $categoria = 'En Proceso';
        } elseif ($ponderado >= 12 && $ponderado <= 16) {
            $porcentaje = 75;
            $categoria = 'Competente';
        } elseif ($ponderado >= 17 && $ponderado <= 20) {
            $porcentaje = 100;
            $categoria = 'Muy Competente';
        } else {
            $categoria = 'Desconocido';
        }

        return [
            'ponderado' => number_format($ponderado, 0),
            'porcentaje' => $porcentaje,
            'categoria' => $categoria,
        ];
    }

    public function visualizar_reporte_notas($id_induction_worker, $intento)
    {

        $induction_worker = InductionWorker::find($id_induction_worker);
        $worker = Worker::find($induction_worker->id_worker);
        $induction = Induction::find($induction_worker->id_induction);
        $detail_induction_worker = DetailInductionWorker::where('induction_worker_id', $induction_worker->id)
            ->where('report', $intento)
            ->orderBy('time', 'asc')
            ->get();

        // Cargar los datos necesarios para el PDF en el arreglo $data
        $casosTotales = $induction_worker->case_count;
        $casosBuenos = count($detail_induction_worker);
        $casosMalos = 8 - $casosBuenos;
        // $logo = Worker::where('id_company', $induction->id_company)->first()->user->photo;
        $data = $detail_induction_worker[0];
        $logo = Company::find($induction->id_company)->url_image_desktop;


        $result = $this->calcularPonderadoPorcentajeYCategoria($data->note_reference, $data->note);
        $ponderado = $result['ponderado'];
        $porcentaje = $result['porcentaje'];
        $categoria = $result['categoria'];


        $data = [
            'induction_worker' => $induction_worker,
            'worker' => $worker,
            'induction' => $induction,
            'imagen' => "https://quickchart.io/chart?c={type:'doughnut', data:{datasets:[{data:[$casosBuenos,$casosMalos],backgroundColor:['rgb(32,164,81)','rgb(255,0,0)'],}],labels:['Encontrado', 'No encontrados'],},options:{title:{display:false},plugins: { datalabels: { color: 'white' } },},}",
            'detail_induction_worker' => $detail_induction_worker,
            'casosTotales' => $casosTotales,
            'casosBuenos' => $casosBuenos,
            'casosMalos' => $casosMalos,
            'nota' => $ponderado,
            'categoria' => $categoria,
            'porcentaje' => $porcentaje,
            'logo' => $logo,
            'logo_taller' => $induction->workshop->photo,
            'data' => $data,
        ];
        $pdf = PDF::loadView('ReportesFormatos.asistenciaPDF', $data);
        // Configura los márgenes directamente en DOMPDF
        if ($induction->id_company == 2) {
            $pdf = PDF::loadView('ReportesFormatos.IsemNotaPdf', $data);
        } else if ($induction->id_company == 4) {
            $errores = round($detail_induction_worker->sum('num_errors'));
            $aciertos = $induction_worker->puntaje - $errores;
            $data['nota'] = $aciertos;
            $data['imagen'] = "https://quickchart.io/chart?c={type:'doughnut', data:{datasets:[{data:[$aciertos,$errores],backgroundColor:['rgb(32,164,81)','rgb(255,0,0)'],}],labels:['Puntaje Inicial', 'Nº Errores'],},options:{title:{display:false},plugins: { datalabels: { color: 'white' } },},}";
            if ($induction->alias == "ANÁLISIS DE FALLAS") {
                $data['json'] = json_decode($detail_induction_worker[0]->json, true);
                $pdf = PDF::loadView('ReportesFormatos.ConfipetrolAnalisisFallas', $data);
            } else {
                $pdf = PDF::loadView('ReportesFormatos.ConfipetrolNotaPdf', $data);
            }
        } else if ($induction->id_company == 3) {
            $errores = round($detail_induction_worker->sum('num_errors'));
            $aciertos = $induction_worker->puntaje - $errores;
            $data['nota'] = $aciertos;
            $data['imagen'] = "https://quickchart.io/chart?c={type:'doughnut', data:{datasets:[{data:[$aciertos,$errores],backgroundColor:['rgb(32,164,81)','rgb(255,0,0)'],}],labels:['Puntaje Inicial', 'Nº Errores'],},options:{title:{display:false},plugins: { datalabels: { color: 'white' } },},}";
            $pdf = PDF::loadView('ReportesFormatos.LuzDelSurNotaPdf', $data);
        }
        return $pdf->stream('reporte.pdf');
    }
    public function descargar_asistencia($id_induction, $fecha_inicio = null, $fecha_fin = null, $id_service)
    {
        // Verifica si al menos una de las fechas es "0000-00-00"
        if ($fecha_inicio === '0000-00-00' || $fecha_fin === '0000-00-00') {
            // No apliques ningún filtro de fecha
            $induction_worker = InductionWorker::where('id_induction', $id_induction)->get();
        } else {
            // Añade la hora correspondiente a las fechas
            $fecha_inicio .= ' 00:00:00';
            $fecha_fin .= ' 23:59:59';

            // Aplica el filtro de fechas solo si ambas fechas son válidas
            $query = InductionWorker::where('id_induction', $id_induction);
            if ($fecha_inicio && $fecha_fin) {
                $query->where('start_date', '>=', $fecha_inicio)
                    ->where('end_date', '<=', $fecha_fin);
            }
            $induction_worker = $query->get();
        }

        $induction = Induction::find($id_induction);
        $result = InductionWorker::join('workers', 'workers.id', '=', 'induction_workers.id_worker')
            ->join('services as s', 's.id', '=', 'workers.id_service')
            ->join('users as u', 'u.id', '=', 'workers.id_user')
            ->where('induction_workers.id_induction', $id_induction)
            ->select('workers.position', 's.name as servicio', 's.id as id_service', 'workers.nombre', 'u.doi', 'workers.apellido')
            ->get();
        $logo = Company::find($induction->id_company)->url_image_desktop;
        $data = [
            'induction_worker' => $induction_worker,
            'induction' => $induction,
            'result' => $result,
            'logo' => $logo,
            'id_service' => $id_service
        ];
        // Configura los márgenes directamente en DOMPDF
        if ($induction->id_company == 2) {
            $pdf = PDF::loadView('ReportesFormatos.IsemAsistenciaPdf', $data);
        } else if ($induction->id_company == 4) {
            $pdf = PDF::loadView('ReportesFormatos.ConfipetrolAsistenciaPdf', $data);
        } else if ($induction->id_company == 3) {
            $pdf = PDF::loadView('ReportesFormatos.LuzDelSurAsistenciaPdf', $data);
        }

        return $pdf->stream('reporte.pdf');
    }




    public function descargar_asistencia_excel(Request $request, $id_induction, $fecha_inicio = null, $fecha_fin = null)
    {
        // Obtener registros de InductionWorker
        // Verifica si al menos una de las fechas es "0000-00-00"
        if ($fecha_inicio === '0000-00-00' || $fecha_fin === '0000-00-00') {
            // No apliques ningún filtro de fecha
            $inductionWorkers = InductionWorker::where('id_induction', $id_induction)->get();
        } else {
            // Añade la hora correspondiente a las fechas
            $fecha_inicio .= ' 00:00:00';
            $fecha_fin .= ' 23:59:59';

            // Aplica el filtro de fechas solo si ambas fechas son válidas
            $query = InductionWorker::where('id_induction', $id_induction);
            if ($fecha_inicio && $fecha_fin) {
                $query->where('start_date', '>=', $fecha_inicio)
                    ->where('end_date', '<=', $fecha_fin);
            }
            $inductionWorkers = $query->get();
        }

        $induction = Induction::find($id_induction);

        // Crear un arreglo vacío para los datos a exportar
        $data = [];
        // Iterar sobre los registros y construir el arreglo de datos
        foreach ($inductionWorkers as $worker) {

            if ($worker->worker->user->name == $worker->worker->user->last_name) {
                $name = $worker->worker->user->name;
            } else {
                $name = $worker->worker->user->name . ' ' . $worker->worker->user->last_name;
            }
            $data[] = [
                'doi' => $worker->worker->user->doi,
                'name' => $name,
                'nota' => $worker->Ponderado,
                'categoria' => $worker->Categoria,
                'porcentaje' => number_format($worker->Porcentaje, 0) . '%',
            ];
        }

        $cabecera = [
            'simulador' => $induction->alias,
            'instructor' => $induction->worker->user->name . ' ' . $induction->worker->user->last_name,
            'fecha' => Carbon::now()->format('d/m/Y'),
        ];

        // Crear una instancia de la clase de exportación y pasar los datos
        $export = new InductionExcelReportExport(collect($data), collect($cabecera));

        // Descargar el archivo Excel utilizando la instancia de exportación
        return Excel::download($export, 'reporte_por_curso.xlsx');
    }

    public function reportealumno(Request $request)
    {
        return view('Supervisor.reportealumno');
    }
    public function reportealumnodetail(Request $request)
    {

        // $worker = Worker::where('code_worker', 'LIKE', '%' . '-' . $request->doi)
        //     ->where('id_company', session('id_company'))
        //     ->first();
        // $inductions = InductionWorker::join('inductions', 'induction_workers.id_induction', '=', 'inductions.id')
        //     ->join('workshops as w', 'inductions.id_workshop', '=', 'w.id') // Inner join con workshops
        //     ->where('induction_workers.id_worker', $worker->id)
        //     ->where('induction_workers.status', '1')
        //     ->orderBy('induction_workers.id', 'desc')
        //     ->select(
        //         'induction_workers.id',
        //         'induction_workers.id_worker',
        //         'inductions.id as induction_id',
        //         'w.id as id_workshop',
        //         'induction_workers.id as induction_workers',
        //         'inductions.date_start',
        //         'inductions.date_end',
        //         'inductions.time_start',
        //         'inductions.time_end',
        //         'w.name as name',
        //         'inductions.alias',
        //         'induction_workers.note'
        //     )->get();
        // $responseData = [
        //     'name' => $worker->user->name,
        //     'last_name' => $worker->user->last_name,
        //     'doi' => $worker->user->doi,
        //     'inductions' => $inductions,
        // ];

        // return response()->json($responseData);
        // $workerIds = Worker::where('code_worker', 'LIKE', '%' . '-' . $request->doi)
        //     ->where('id_company', session('id_company'))
        //     ->pluck('id');

        // $inductions = InductionWorker::join('inductions', 'induction_workers.id_induction', '=', 'inductions.id')
        //     ->join('workshops as w', 'inductions.id_workshop', '=', 'w.id') // Inner join con workshops
        //     ->whereIn('induction_workers.id_worker', $workerIds) // Usar WHERE IN
        //     ->where('induction_workers.status', '1')
        //     ->orderBy('induction_workers.id', 'desc')
        //     ->select(
        //         'induction_workers.id',
        //         'induction_workers.id_worker',
        //         'inductions.id as induction_id',
        //         'w.id as id_workshop',
        //         'induction_workers.id as induction_workers',
        //         'inductions.date_start',
        //         'inductions.date_end',
        //         'inductions.time_start',
        //         'inductions.time_end',
        //         'w.name as name',
        //         'inductions.alias',
        //         'induction_workers.num_report'
        //     )->get();
        $workerIds = Worker::where('code_worker', 'LIKE', '%' . '-' . $request->doi)
            ->where('id_company', session('id_company'))
            ->pluck('id');

        $inductions = InductionWorker::whereIn('id_worker', $workerIds)->get();

        $inductionsData = [];

        foreach ($inductions as $induction) {
            $inductionData = [
                'id_induction_workers' => $induction->id,
                'date_start' => $induction->induction->date_start . ' ' . $induction->induction->time_start,
                'date_end' => $induction->induction->date_end . ' ' . $induction->induction->time_end,
                'num_report' => $induction->num_report,
                'name_taller' => $induction->induction->alias,
            ];
            $intentos = [];
            for ($i = 1; $i <= $induction->num_report; $i++) {
                $data = $induction->detailsByReport($i)->first();
                $intentos[] = [
                    'intento' => $data->report,
                    'note' => $data->note,
                    'note_reference' => $data->note_reference,
                    'date_start' => $data->start_date,
                    'date_end' => $data->end_date,
                ];
            }
            $inductionData['intentos'] = $intentos;
            $inductionsData[] = $inductionData;
        }
        $responseData = [
            'workers' => $workerIds,
            'inductions' => $inductionsData,
        ];

        return response()->json($responseData);
    }
}
