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
use App\Models\Departamento;
use App\Models\WorkshopCompany;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\InductionWorker;
use Dompdf\Dompdf;
use PDF; // Importar el facade de PDF
use App\Exports\InductionExcelReportExport;
use App\Exports\ExcelGeneralConfipetrol;

use App\Models\Company;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use ZipArchive;
use Illuminate\Support\Facades\Storage;

use App\Exports\ExportDataCervExcel;

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


    private function dataDashboard($id_company)
    {
        $services = Service::where('id_company', $id_company)->withCount('workers')->get();

        $servicesData = $services->map(function ($service) {
            return [
                'name' => $service->name,
                'numero_workers' => $service->workers_count
            ];
        });

        $inductions = Induction::where('id_company', $id_company)->with('workers')
            ->where('status', '1')
            ->get();

        $inductionsData = [];

        foreach ($inductions as $induction) {
            $min_nota = $induction->minimum_passing_note;
            $sinNota = 0;
            $aprovados = 0;
            $reprobados = 0;
            if ($id_company == 4) {
                foreach ($induction->workers as $worker) {
                    if ($worker->notaConfipetrol() == '-') {
                        $sinNota++;
                    } else if ($worker->notaConfipetrol() >= $min_nota) {
                        $aprovados++;
                    } else {
                        $reprobados++;
                    }
                }
            } else if ($id_company == 2) {
                foreach ($induction->workers as $worker) {

                    if ($worker->num_report == 0) {
                        $sinNota++;
                    } else {
                        $nota = $worker->notaIsemDashboard();

                        if ($nota >= $min_nota) {
                            $aprovados++;
                        } else {
                            $reprobados++;
                        }
                    }
                }
            } else if ($id_company == 3) {
                foreach ($induction->workers as $worker) {
                    if ($worker->num_report == 0) {
                        $sinNota++;
                    } else {
                        $nota = $worker->notaLuzDelSur();
                        if ($nota >= $min_nota) {
                            $aprovados++;
                        } else {
                            $reprobados++;
                        }
                    }
                }
            }
            $inductionsData[] = [
                'alias' => $induction->alias,
                'status' => $induction->status,
                'workers_count' => $induction->workers->count(),
                'month' => Carbon::parse($induction->date_start)->locale('es')->isoFormat('MMMM'),
                'year' => Carbon::parse($induction->date_start)->format('Y'),
                'aprovados' => $aprovados,
                'reprobados' => $reprobados,
                'sinNota' => $sinNota,
            ];
        }
        return ['servicios' => $servicesData->toArray(), 'inducciones' => $inductionsData];
    }
    public function index(Request $request)
    {
        $id_company = session('id_company');
        $data = $this->dataDashboard($id_company);

        return view('Supervisor.index', compact('data'));
    }

    public function servicio(Request $request)
    {
        $id_company = session('id_company');
        $services = Service::where('id_company', $id_company)->where('status', 1)->get();
        return view('Supervisor.servicio', compact('services'));
    }

    public function reporte(Request $request)
    {
        $filter_start = $request->filter_start ?? null;
        $filter_end = $request->filter_end ?? null;
        $query = Induction::where('id_company', session('id_company'))
            ->where('status', '1');

        // Si ambos filtros están presentes, aplicar el filtrado por rango de fechas
        if ($filter_start && $filter_end) {
            $query = $query->where('date_start', '>=', $filter_start)
                ->where('date_start', '<=', $filter_end);
        }

        $inductions = $query->orderBy('id', 'desc')->get();

        // Removido para integrar la lógica de filtrado
        // dd($inductions);

        $services = Service::where('id_company', session('id_company'))->get();
        return view('Supervisor.reporte', compact('inductions', 'services', 'filter_start', 'filter_end'));
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

        // Recuperar los departamentos de la compañía actual
        $departamentos = Departamento::where('company_id', $id_company)->get();

        return view('Supervisor.Matricula.matricula', compact('id_service', 'workers', 'nombre_service', 'departamentos'));
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
            $worker->employee_code = $request->employee_code;
            $worker->position = $request->position;
            $worker->department = $request->department;
            $worker->license = $request->license_number;
            $worker->category = $request->license_category;
            $worker->celular = $request->celular ?? '';
            if ($request->photo_base64) {
                $worker->photo = $request->photo_base64;
            }
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

            // Obtener las cabeceras (primera fila)
            $cabeceras = $datos[0][0];

            // Convertir todas las cabeceras a minúsculas
            $cabeceras = array_map('strtolower', $cabeceras);

            // Buscar las columnas requeridas
            $indiceNombres = array_search('nombres', $cabeceras);
            $indiceApellidos = array_search('apellidos', $cabeceras);
            $indiceDOI = array_search('doi', $cabeceras);
            $indiceCargo = array_search('cargo', $cabeceras);

            // Buscar las columnas opcionales
            $indiceCodigoTrabajador = array_search('codigo de trabajador', $cabeceras);
            $indiceDepartamento = array_search('departamento', $cabeceras);

            // Verificar si se encontraron todas las columnas requeridas
            if ($indiceNombres === false || $indiceApellidos === false || $indiceDOI === false || $indiceCargo === false) {
                Session::flash('error', 'El archivo Excel no tiene todas las columnas requeridas (nombres, apellidos, doi, cargo).');
                return redirect()->back();
            }

            // Iterar sobre las filas y ejecutar el método createTrabajadorMasivo
            foreach ($datos as $hoja) {
                $contador = 0;
                foreach ($hoja as $fila) {
                    if ($contador == 0) { // Si es la primera fila (cabecera), se omite
                        $contador++;
                        continue;
                    }

                    // Obtener los valores de las columnas opcionales, o usar un valor predeterminado si no se encontraron
                    $codigoTrabajador = $indiceCodigoTrabajador !== false ? $fila[$indiceCodigoTrabajador] : null;
                    $departamento = $indiceDepartamento !== false ? $fila[$indiceDepartamento] : null;

                    $result = $this->userController->createTrabajadorMasivo(
                        $fila[$indiceNombres],
                        $fila[$indiceApellidos],
                        $fila[$indiceDOI],
                        $fila[$indiceCargo],
                        $request->id_service,
                        $id_company,
                        $codigoTrabajador,
                        $departamento,
                    );

                    if (!$result) {
                        $filasConProblemas[] = $fila; // Agregar fila a las que tienen problemas
                    }
                    $contador++;
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
                    $errorString .= $filasConProblemas[$i][$indiceDOI];

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

                        // Si fila[0] es null o una cadena vacía, se omite esta iteración
                        if ($fila[0] === null || $fila[0] === '') {
                            continue;
                        }

                        $service = null;
                        $worker = null;

                        if ($fila[1]) {
                            $id_company = session('id_company');
                            $service = Service::where('name', $fila[1])->where('id_company', $id_company)
                                ->where('status', '1')
                                ->first();
                        }

                        if ($fila[0]) {
                            $worker = Worker::where('code_worker', 'LIKE', '%' . $fila[0] . '%')
                                ->where('id_company', session('id_company'))
                                ->where('id_service', optional($service)->id) // Use optional() to handle null service
                                ->first();
                        }
                        if (!$service) {
                            // Agregar esta fila al array de filas con problemas
                            $filasConProblemas[] = 'El servicio no existe en la fila ' . $filaActual . '. Por favor, verifica el servicio.';
                        }
                        if (!$worker) {
                            // Agregar esta fila al array de filas con problemas
                            $filasConProblemas[] = 'El trabajador no existe en la fila ' . $fila[0] . '. Por favor, verifica el trabajador.';
                        }

                        if ($worker) {
                            // Validar que el trabajador no esté en otra inducción que se cruce con esta
                            $induction = Induction::find($id_induction);
                            $induction_afters = Induction::where('id_company', $induction->id_company)
                                ->where('status', '1')
                                ->where('alias', 'like', '%' . $induction->alias . '%')
                                ->where('id', '!=', $induction->id)
                                ->where('date_start', '<=', $induction->date_end)
                                ->where('date_end', '>=', $induction->date_start)
                                ->get();

                            $validar = true;

                            foreach ($induction_afters as $induction_after) {
                                $existingRecordInAfter = InductionWorker::where('id_induction', $induction_after->id)
                                    ->where('id_worker', $worker->id)
                                    ->first();
                                if ($existingRecordInAfter) {
                                    $filasConProblemas[] = 'El trabajador con DOI ' . $worker->user->doi . ' ya está inscrito en otro taller activo. El taller con el que se cruza es: "' . $induction_after->alias . '", programado del ' . date('d-m-Y', strtotime($induction_after->date_start)) . ' al ' . date('d-m-Y', strtotime($induction_after->date_end)) . ' (ID: ' . $induction_after->id . ').';
                                    $validar = false;
                                    break; // Termina el bucle foreach
                                }
                            }

                            if ($validar) {
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
                                        $filasConProblemas[] = 'El trabajador con DOI ' . $worker->user->doi . ' ha sido activado.';
                                    } else {
                                        $filasConProblemas[] = 'El trabajador con DOI ' . $worker->user->doi . ' ya está registrado.';
                                    }
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
            'name' => $requestData->workshop->name,
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
            'department' => $worker->department,
            'employee_code' => $worker->employee_code,
            'celular' => $worker->celular,
            'photo' => $worker->photo,
            'license' => $worker->license,
            'category' => $worker->category,
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
            $induction = Induction::find($request->id_induction);
            $induction_afters = Induction::where('id_company', $induction->id_company)
                ->where('status', '1')
                ->where('alias', 'like', '%' . $induction->alias . '%')
                ->where('id', '!=', $induction->id)
                ->where('date_start', '<=', $induction->date_end)
                ->where('date_end', '>=', $induction->date_start)
                ->get();

            foreach ($induction_afters as $induction_after) {
                $existingRecordInAfter = InductionWorker::where('id_induction', $induction_after->id)
                    ->where('id_worker', $request->id_worker)
                    ->first();
                if ($existingRecordInAfter) {
                    return redirect()->back()->with('error', 'El usuario ya está inscrito en otro taller activo. El taller con el que se cruza es: "' . $induction_after->alias . '", programado del ' . date('d-m-Y', strtotime($induction_after->date_start)) . ' al ' . date('d-m-Y', strtotime($induction_after->date_end)) . ' (ID: ' . $induction_after->id . ').');
                }
            }

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

    public function generarPDFISem($id_induction_worker, $intento, $modo = 'Evaluación')
    {
        $induction_worker = InductionWorker::find($id_induction_worker);
        $worker = Worker::find($induction_worker->id_worker);
        $induction = Induction::find($induction_worker->id_induction);
        $detail_induction_worker = DetailInductionWorker::where('induction_worker_id', $induction_worker->id)
            ->where('report', $intento);

        if ($modo == 'Entrenamiento') {
            $detail_induction_worker = $detail_induction_worker->where('entrenamiento', 1);
        } else {
            $detail_induction_worker = $detail_induction_worker->where('entrenamiento', '<>', 1);
        }

        $detail_induction_worker = $detail_induction_worker->orderBy('id', 'asc')->get();
        $casosTotales = $induction_worker->case_count;
        $casosBuenos = $detail_induction_worker->filter(function ($detail) {
            return floatval($detail->identified) != 0.0;
        })->count();
        $casosMalos = 8 - $casosBuenos;
        $data = $detail_induction_worker[0];
        $logo = Company::find($induction->id_company)->url_image_desktop;

        $result = $this->calcularPonderadoPorcentajeYCategoria($data->note_reference, $data->note);
        $ponderado = $result['ponderado'];
        $porcentaje = $result['porcentaje'];
        $categoria = $result['categoria'];
        $note_reference = $data->note_reference;

        $consulta = DB::table('detail_induction_workers')
            ->select(DB::raw('COALESCE(MAX(report) , 0) AS resultado'))
            ->where('induction_worker_id', $id_induction_worker);

        if ($modo == 'Entrenamiento') {
            $resultado = $consulta->where('entrenamiento', '1')->first();
        } else {
            $resultado = $consulta->where('entrenamiento', '<>', '1')->first();
        }

        $nuevoIntento = $resultado->resultado;

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
            'intento' => $intento,
            'intentos' => $induction_worker->num_report,
            'modo' => $modo,
            'num_reportes' => $nuevoIntento
        ];
        $datas = $induction_worker->notaIsemByIntento($intento);

        $data['ponderado'] = 1;
        $data['porcentaje'] = $datas['porcentaje'];
        $data['categoria'] = $datas['categoria'];
        $data['nota'] = $datas['total_sum'];
        $data['extra'] = $datas;


        $pdf = PDF::loadView('ReportesFormatos.IsemNotaPdf', $data);
        return $pdf;
    }

    private function genReportCerv($induction_worker, $worker, $induction, $intento, $modo)
    {
        $data = [
            'header' => $induction->header(),
            'data' => $induction_worker->jsonNoteFilter($modo == 'Entrenamiento' ? 1 : 0, $intento),
        ];

        $logoPath = $data['header']['logo'];
        $sinPhoto = 'logo/sin-photo.png';
        // Asegurarse de que $logoPath tenga un valor predeterminado válido
        if (empty($logoPath)) {
            $logoPath = 'logo/logo_negro.png'; // URL del logo por defecto
        }

        // Verificar si el archivo existe en la carpeta public de Laravel
        if (!file_exists(public_path($logoPath))) {
            $logoPath = 'logo/logo_negro.png'; // Usar el logo por defecto si el archivo no existe
        }

        // Continuar con la lógica para manejar $logoPath...
        // Leer el contenido del archivo y convertirlo a base64
        $logoData = file_get_contents(public_path($logoPath));
        $logoBase64 = 'data:image/png;base64,' . base64_encode($logoData);

        $sinPhoto = file_get_contents(public_path($sinPhoto));
        $sinPhotoBase64 = 'data:image/png;base64,' . base64_encode($sinPhoto);

        $data['logo'] = $logoBase64;
        $data['sinPhoto'] = $sinPhotoBase64;

        if (strpos($data['header']['taller'], 'Extintor') !== false) {
            $pdf = PDF::loadView('ReportesFormatos.CERV.extintores', $data);
        } else if (strpos($data['header']['taller'], 'Montacarga') !== false) {
            $pdf = PDF::loadView('ReportesFormatos.CERV.simuladormanejo', $data);
        } else {
            abort(403, 'No se puede generar el reporte taller no reconocido');
        }

        return $pdf->stream('ReporteIndividual.pdf');
    }

    public function visualizar_reporte_notas($id_induction_worker, $intento, $modo)
    {
        $induction_worker = InductionWorker::find($id_induction_worker);
        $worker = Worker::find($induction_worker->id_worker);
        $induction = Induction::find($induction_worker->id_induction);

        if ($induction->id_company == 5) {
            return $this->genReportCerv($induction_worker, $worker, $induction, $intento, $modo);
        }

        $detail_induction_worker = DetailInductionWorker::where('induction_worker_id', $induction_worker->id)
            ->where('report', $intento);

        if ($modo == 'Entrenamiento') {
            $detail_induction_worker = $detail_induction_worker->where('entrenamiento', 1);
        } else {
            $detail_induction_worker = $detail_induction_worker->where('entrenamiento', '<>', 1);
        }

        $detail_induction_worker = $detail_induction_worker->orderBy('id', 'asc')->get();
        // Cargar los datos necesarios para el PDF en el arreglo $data
        $casosTotales = $induction_worker->case_count;
        $casosBuenos = $detail_induction_worker->filter(function ($detail) {
            return floatval($detail->identified) != 0.0;
        })->count();
        $casosMalos = 8 - $casosBuenos;
        // $logo = Worker::where('id_company', $induction->id_company)->first()->user->photo;
        $data = $detail_induction_worker[0];
        $logo = Company::find($induction->id_company)->url_image_desktop;


        $result = $this->calcularPonderadoPorcentajeYCategoria($data->note_reference, $data->note);
        $ponderado = $result['ponderado'];
        $porcentaje = $result['porcentaje'];
        $categoria = $result['categoria'];
        $note_reference = $data->note_reference;

        $consulta = DB::table('detail_induction_workers')
            ->select(DB::raw('COALESCE(MAX(report) , 0) AS resultado'))
            ->where('induction_worker_id', $id_induction_worker);

        if ($modo == 'Entrenamiento') {
            $resultado = $consulta->where('entrenamiento', '1')->first();
        } else {
            $resultado = $consulta->where('entrenamiento', '<>', '1')->first();
        }

        $nuevoIntento = $resultado->resultado;

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
            'intento' => $intento,
            'intentos' => $induction_worker->num_report,
            'modo' => $modo,
            'num_reportes' => $nuevoIntento
        ];

        $pdf = PDF::loadView('ReportesFormatos.asistenciaPDF', $data);
        $data_report = json_decode($induction_worker->data_report, true);

        // Configura los márgenes directamente en DOMPDF
        if ($induction->id_company == 2) {

            $datas = $induction_worker->notaIsemByIntento($intento);

            $data['ponderado'] = 1;
            $data['porcentaje'] = $datas['porcentaje'];
            $data['categoria'] = $datas['categoria'];
            $data['nota'] = $datas['total_sum'];
            $data['extra'] = $datas;
            $pdf = PDF::loadView('ReportesFormatos.IsemNotaPdf', $data);
            return $pdf->stream('ISEMReporte.pdf');
        } else if ($induction->id_company == 4) {

            $errores = round($detail_induction_worker->sum('num_errors'));
            $aciertos = $induction_worker->puntaje - $errores;
            $data['nota'] = $aciertos;
            $data['imagen'] = "https://quickchart.io/chart?c={type:'doughnut', data:{datasets:[{data:[$aciertos,$errores],backgroundColor:['rgb(32,164,81)','rgb(255,0,0)'],}],labels:['Puntaje Inicial', 'Nº Errores'],},options:{title:{display:false},plugins: { datalabels: { color: 'white' } },},}";

            if (strtolower($induction->alias) == "análisis de fallas") {
                $data['json'] = json_decode($detail_induction_worker[0]->json, true);
                $pdf = PDF::loadView('ReportesFormatos.ConfipetrolAnalisisFallas', $data);
            } elseif (strtolower($induction->alias) == "seguridad de procesos") {
                $data['imagen'] = "https://quickchart.io/chart?c={type:'doughnut', data:{datasets:[{data:[$aciertos,$errores],backgroundColor:['rgb(32,164,81)','rgb(255,0,0)'],}],labels:['Puntaje Inicial', 'Puntaje de Errores'],},options:{title:{display:false},plugins: { datalabels: { color: 'white' } },},}";

                $errores = 0;
                foreach ($detail_induction_worker as $detail) {
                    $multiplicador = $detail->case == 'EPPs' ? 1 : 5;
                    $errores += round($detail->num_errors) * $multiplicador;
                }
                $aciertos = $induction_worker->puntaje - $errores;
                $data['nota'] = $aciertos;
                $pdf = PDF::loadView('ReportesFormatos.ConfipetrolSeguridadProcesos', $data);
            } else {
                $pdf = PDF::loadView('ReportesFormatos.ConfipetrolNotaPdf', $data);
            }

            return $pdf->stream('reporteConfiPetrol.pdf');
        } else if ($induction->id_company == 3) {
            $tiempoObjetivo = 0.5;
            $data['tiempoObjetivo'] = $tiempoObjetivo;
            // dd($induction_worker->notaLuzDelSurIntento($intento,$modo,$tiempoObjetivo));
            $data['nota'] = $induction_worker->notaLuzDelSurIntento($intento, $modo, $tiempoObjetivo);
            $pdf = PDF::loadView('ReportesFormatos.LuzDelSurNotaPdf', $data);
            return $pdf->stream('reporteLuzDelSur.pdf');
        }

        abort(403, 'No se encontró el reporte solicitado.');
    }

    public function descargar_reporte_excel($id_induction, $modo)
    {
        $induction_id = $id_induction;
        $modo = $modo;

        $induction = Induction::find($induction_id);
        $workers = $induction->workers->filter(function ($worker) {
            return $worker->status == '1';
        });

        $data = $workers->map(function ($worker) use ($modo) {
            return $worker->jsonNote();
        });

        $export = new ExportDataCervExcel(collect($data));
        $filename = 'reporte_' . $induction->alias . '_' . date('Y-m-d_H-i-s') . '.xlsx';
        return Excel::download($export, $filename);
    }

    // $isValid = isset($data_report) && is_array($data_report) && array_key_exists($intento, $data_report);
    // if (!$isValid) {
    //     // Configura los márgenes directamente en DOMPDF
    //     if ($induction->id_company == 2) {
    //         $pdf = PDF::loadView('ReportesFormatos.IsemNotaPdf', $data);
    //     } else if ($induction->id_company == 4) {
    //         $errores = round($detail_induction_worker->sum('num_errors'));
    //         $aciertos = $induction_worker->puntaje - $errores;
    //         $data['nota'] = $aciertos;
    //         $data['imagen'] = "https://quickchart.io/chart?c={type:'doughnut', data:{datasets:[{data:[$aciertos,$errores],backgroundColor:['rgb(32,164,81)','rgb(255,0,0)'],}],labels:['Puntaje Inicial', 'Nº Errores'],},options:{title:{display:false},plugins: { datalabels: { color: 'white' } },},}";

    //         if (strtolower($induction->alias) == "análisis de fallas") {
    //             $data['json'] = json_decode($detail_induction_worker[0]->json, true);
    //             $pdf = PDF::loadView('ReportesFormatos.ConfipetrolAnalisisFallas', $data);
    //         } elseif (strtolower($induction->alias) == "seguridad de procesos") {
    //             $data['imagen'] = "https://quickchart.io/chart?c={type:'doughnut', data:{datasets:[{data:[$aciertos,$errores],backgroundColor:['rgb(32,164,81)','rgb(255,0,0)'],}],labels:['Puntaje Inicial', 'Puntaje de Errores'],},options:{title:{display:false},plugins: { datalabels: { color: 'white' } },},}";

    //             $errores = 0;
    //             foreach ($detail_induction_worker as $detail) {
    //                 $multiplicador = $detail->case == 'EPPs' ? 1 : 5;
    //                 $errores += round($detail->num_errors) * $multiplicador;
    //             }
    //             $aciertos = $induction_worker->puntaje - $errores;
    //             $data['nota'] = $aciertos;
    //             $pdf = PDF::loadView('ReportesFormatos.ConfipetrolSeguridadProcesos', $data);
    //         } else {
    //             $pdf = PDF::loadView('ReportesFormatos.ConfipetrolNotaPdf', $data);
    //         }

    //         return $pdf->stream('reporte.pdf');
    //     } else if ($induction->id_company == 3) {
    //         $errores = round($detail_induction_worker->sum('num_errors'));
    //         $aciertos = $induction_worker->puntaje - $errores;
    //         $data['nota'] = $aciertos;
    //         $data['imagen'] = "https://quickchart.io/chart?c={type:'doughnut', data:{datasets:[{data:[$aciertos,$errores],backgroundColor:['rgb(32,164,81)','rgb(255,0,0)'],}],labels:['Puntaje Inicial', 'Nº Errores'],},options:{title:{display:false},plugins: { datalabels: { color: 'white' } },},}";
    //         $pdf = PDF::loadView('ReportesFormatos.LuzDelSurNotaPdf', $data);
    //         return $pdf->stream('reporteLuzDelSur.pdf');
    //     }
    // } else {
    //     $dataPdfDecoded = base64_decode($data_report[$intento]);
    //     // Crea una respuesta con el PDF decodificado y haz un stream de ella
    //     return response($dataPdfDecoded, 200, [
    //         'Content-Type' => 'application/pdf',
    //         'Content-Disposition' => 'attachment; filename="reporte_recuperado.pdf"',
    //     ]);
    // }

    // // Codifica el PDF en base64
    // $output = $pdf->output();
    // $base64Pdf = base64_encode($output);

    // $data_report = json_decode($induction_worker->data_report, true);
    // $data_report[$intento] = $base64Pdf;
    // $induction_worker->data_report = json_encode($data_report);

    // $induction_worker->save();

    // return $pdf->download('reporte.pdf');
    public function descargar_asistencia($id_induction, $fecha_inicio = null, $fecha_fin = null, $id_service)
    {
        $induction_worker = InductionWorker::where('id_induction', $id_induction)
            ->orderBy('id', 'asc')
            ->where('status', '1')
            ->get();
        $induction = Induction::find($id_induction);
        $result = InductionWorker::where('induction_workers.id_induction', $id_induction)
            ->orderBy('id', 'asc')
            ->where('status', '1')
            ->get();

        $logo = Company::find($induction->id_company)->url_image_desktop;
        if ($induction->worker->user->signature != null) {
            $signaturePath = public_path($induction->worker->user->signature);
            if (file_exists($signaturePath)) {
                $dataImage = file_get_contents($signaturePath);
                $base64Signature = 'data:image/' . pathinfo($signaturePath, PATHINFO_EXTENSION) . ';base64,' . base64_encode($dataImage);
            } else {
                $base64Signature = null;
            }
        } else {
            $base64Signature = null;
        }

        // Convertir el logo del taller a base64
        $logoTallerPath = $induction->header()['logo'];
        if ($logoTallerPath) {
            $logoTallerFullPath = public_path($logoTallerPath);
            if (file_exists($logoTallerFullPath)) {
                $logoTallerImage = file_get_contents($logoTallerFullPath);
                $base64LogoTaller = 'data:image/' . pathinfo($logoTallerFullPath, PATHINFO_EXTENSION) . ';base64,' . base64_encode($logoTallerImage);
            } else {
                $base64LogoTaller = null;
            }
        } else {
            $base64LogoTaller = null;
        }

        $data = [
            'induction_worker' => $induction_worker,
            'induction' => $induction,
            'result' => $result,
            'logo' => $logo,
            'id_service' => $id_service,
            'signature' => $base64Signature,
            'fecha_inicio' => $fecha_inicio,
            'fecha_fin' => $fecha_fin,
            'logo_taller' => $base64LogoTaller,
        ];

        // Configura los márgenes directamente en DOMPDF
        if ($induction->id_company == 2) {
            $pdf = PDF::loadView('ReportesFormatos.IsemAsistenciaPdf', $data);
        } else if ($induction->id_company == 4) {
            if ($induction->alias == 'Aislamiento y bloqueo de energías') {
                $pdf = PDF::loadView('ReportesFormatos.ConfipetrolAsistenciaAislamientoPdf', $data)
                    ->setPaper('a4', 'landscape');
            } elseif ($induction->alias == 'Seguridad de Procesos') {
                $pdf = PDF::loadView('ReportesFormatos.ConfipetrolAsistenciaSeguridadPdf', $data)->setPaper('a4', 'landscape');
            } else {
                $pdf = PDF::loadView('ReportesFormatos.ConfipetrolAsistenciaPdf', $data)->setPaper('a4', 'landscape');
            }
        } else if ($induction->id_company == 3) {
            $pdf = PDF::loadView('ReportesFormatos.LuzDelSurAsistenciaPdf', $data);
        } else if ($induction->id_company == 5) {
            $data['header'] = $induction->header();
            $data['newNoteJson'] = $induction->newNoteJson();
            $pdf = PDF::loadView('ReportesFormatos.CervGeneral', $data)
                ->setPaper('a4', 'landscape');
        } else {
            abort(403, 'Usted no tiene un reporte asignado');
        }

        return $pdf->stream('reporte.pdf');
    }
    private function generarDataGeneral($ids_induction, $id_induction, $fecha_inicio, $fecha_fin, $path)
    {
        // Si id_service es null o 0, obtén todos los registros sin filtrar por id_service
        $inductionWorkers = InductionWorker::whereIn('id_induction', $ids_induction)
            ->orderBy('id', 'asc')
            ->get();

        $induction = Induction::find($id_induction);

        // Crear un arreglo vacío para los datos a exportar
        $data = [];
        // Iterar sobre los registros y construir el arreglo de datos

        foreach ($inductionWorkers as $worker) {
            // Verificar si el status es igual a 1
            if ($worker->status == 1) {
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
        }

        // Crear una instancia de la clase de exportación y pasar los datos
        $cabecera = [
            'simulador' => $induction->alias,
            'instructor' => $induction->worker->user->name . ' ' . $induction->worker->user->last_name,
            'fecha' => Carbon::now()->format('d/m/Y'),
        ];

        $id_company = session('id_company');


        $headerKeys = ["intento", "nombre", "empresa", "codigo", "cargo", "start_date", "id_service"];
        $headerMap = [
            "codigo" => "Documento de identidad",
            "nombre" => "Datos del Trajador",
            "empresa" => "Empresa",
            "cargo" => "Cargo",
        ];
        if ($induction->alias == 'Aislamiento y bloqueo de energías') {
            $detailKeys = ["start_date", "maxNota", "EPPs", "Equipos de bloqueo", "Aislamiento", "Bloqueo y tarjeteo"];

            $detailMap = [
                "start_date" => "Fecha de inicio",
                "EPPs" => "EPPs",
                "Equipos de bloqueo" => "Equipos de bloqueo",
                "Aislamiento" => "Aislamiento",
                "Bloqueo y tarjeteo" => "Bloqueo y tarjeteo",
                "maxNota" => "Nota"
            ];
        } elseif ($induction->alias == 'Seguridad de Procesos') {

            $detailKeys = [
                "start_date",
                "EPPs",
                "Equipos de bloqueo",
                "Aislamiento",
                "Bloqueo y tarjeteo",
                "Derrame de crudo",
                "Fuga de agua",
                "Deterioro de tuberías",
                "Desgaste de estructuras",
                "Personaje de caída",
                "Derrame de barriles",
                "Camión de grua",
                "Ingreso al tanque",
                "maxNota"
            ];
            $detailMap = [
                "start_date" => "Fecha de inicio",
                "EPPs" => "EPPs",
                "Equipos de bloqueo" => "Equipos de bloqueo",
                "Aislamiento" => "Aislamiento",
                "Bloqueo y tarjeteo" => "Bloqueo y tarjeteo",
                "Derrame de crudo" => "Derrame de crudo",
                "Fuga de agua" => "Fuga de agua",
                "Deterioro de tuberías" => "Deterioro de tuberías",
                "Desgaste de estructuras" => "Desgaste de estructuras",
                "Personaje de caída" => "Personaje de caída",
                "Derrame de barriles" => "Derrame de barriles",
                "Camión de grua" => "Camión de grua",
                "Ingreso al tanque" => "Ingreso al tanque",
                "maxNota" => "Nota"
            ];
        } else {
            $detailKeys = [
                "start_date",
                "maxNota"
            ];
            $detailMap = [
                "start_date" => "Fecha de inicio",
                "maxNota" => "Nota"
            ];
        }
        $data = $this->notaConfipetrolExcel($inductionWorkers, $headerKeys, $detailKeys, $induction->alias, $fecha_inicio, $fecha_fin);

        // Función de comparación para ordenar por 'start_date'
        usort($data, function ($a, $b) {
            // Manejar null values y formato de fecha
            $dateA = $a['start_date'] ? strtotime($a['start_date']) : 0;
            $dateB = $b['start_date'] ? strtotime($b['start_date']) : 0;

            return $dateA - $dateB;
        });

        // if ('Seguridad de Procesos' == $induction->alias) {
        //     dd($data);
        // }

        $export = new ExcelGeneralConfipetrol(collect($data), collect($cabecera), collect($headerMap), collect($detailMap));

        $filename = $cabecera['simulador'] . '_' . date('Y-m-d_H-i-s') . '.xlsx';
        Excel::store($export, $path . $filename, 'local');
    }

    public function reporteGeneral(Request $request)
    {
        $id_company = session('id_company');
        // Variables de fecha y servicio, ajustar según sea necesario
        $fecha_inicio = null;
        $fecha_fin = null;
        $id_service = null;

        $inductions = Induction::select(
            'alias',
            DB::raw('array_agg(id) as ids') // Agrega los IDs de cada grupo
        )
            ->where('id_company', $id_company)
            ->where('status', true)
            ->groupBy('alias')
            ->get();

        // Crea el directorio principal para almacenar los informes
        $reportDir = 'reportes_excel';
        Storage::makeDirectory($reportDir);

        // Crea un directorio para la inducción específica con la fecha y hora actual
        $inductionDir = $reportDir . '/' . date('Y-m-d_H-i-s');
        Storage::makeDirectory($inductionDir);


        foreach ($inductions as $induction) {
            // Asegurarse de que los ids sean un array
            $ids = $induction->ids;
            if (!is_array($ids)) {
                $ids = explode(',', trim($ids, '{}'));
            }

            // Asumiendo que generarDataGeneral ahora retorna el path del archivo Excel generado
            $this->generarDataGeneral($ids, $ids[0], $fecha_inicio, $fecha_fin, $inductionDir . '/');
        }

        // Crea un archivo ZIP
        $tempZipPath = tempnam(sys_get_temp_dir(), 'reportes_induction');
        $zipFileName = basename($tempZipPath) . '.zip';
        $zipFilePath = storage_path('app/' . $reportDir . '/' . $zipFileName);

        $zip = new ZipArchive;
        if ($zip->open($zipFilePath, ZipArchive::CREATE) === true) {
            // Añade cada PDF al archivo ZIP
            foreach (Storage::files($inductionDir) as $file) {
                $zip->addFile(Storage::path($file), basename($file));
            }

            $zip->close();
        }

        // Elimina el directorio de la inducción
        Storage::deleteDirectory($inductionDir);

        // Descarga el archivo ZIP
        return response()->download($zipFilePath);
    }

    public function descargar_asistencia_excel(Request $request, $id_induction, $fecha_inicio = null, $fecha_fin = null, $id_service = null)
    {
        // Obtener registros de InductionWorker
        if ($id_service !== null && $id_service != 0) {
            // Filtra por id_service si está presente y es diferente de 0
            $inductionWorkers = InductionWorker::whereHas('worker', function ($query) use ($id_service) {
                $query->where('id_service', $id_service);
            })
                ->where('id_induction', $id_induction)
                ->orderBy('id', 'asc')
                ->get();
        } else {
            // Si id_service es null o 0, obtén todos los registros sin filtrar por id_service
            $inductionWorkers = InductionWorker::where('id_induction', $id_induction)
                ->orderBy('id', 'asc')
                ->get();
        }

        if ($fecha_inicio !== '0000-00-00' && $fecha_fin !== '0000-00-00') {
            $fecha_inicio .= ' 00:00:00';
            $fecha_fin .= ' 23:59:59';
        } else {
            $fecha_inicio = null;
            $fecha_fin = null;
        }

        $induction = Induction::find($id_induction);



        // Crear un arreglo vacío para los datos a exportar
        $data = [];
        // Iterar sobre los registros y construir el arreglo de datos

        foreach ($inductionWorkers as $worker) {
            // Verificar si el status es igual a 1
            if ($worker->status == 1) {
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
        }

        // Crear una instancia de la clase de exportación y pasar los datos
        $cabecera = [
            'simulador' => $induction->alias,
            'instructor' => $induction->worker->user->name . ' ' . $induction->worker->user->last_name,
            'fecha' => Carbon::now()->format('d/m/Y'),
        ];

        $id_company = session('id_company');

        switch ($id_company) {
            case 2:
                // dd($data, $cabecera, $inductionWorkers[16]->notaIsemByAllIntentos(), $inductionWorkers[16]);
                $data = [];
                // Iterar sobre los registros y construir el arreglo de datos

                foreach ($inductionWorkers as $worker) {
                    // Verificar si el status es igual a 1
                    if ($worker->status == 1) {
                        if ($worker->worker->user->name == $worker->worker->user->last_name) {
                            $name = $worker->worker->user->name;
                        } else {
                            $name = $worker->worker->user->name . ' ' . $worker->worker->user->last_name;
                        }

                        $notaIsemData = $worker->notaIsemByAllIntentos();

                        $data[] = [
                            'doi' => $worker->worker->user->doi,
                            'name' => $name,
                            'nota' => $notaIsemData['total_sum'] == 0.0 ? '0' : $notaIsemData['total_sum'],
                            'categoria' => $notaIsemData['categoria'],
                            'porcentaje' => number_format($notaIsemData['porcentaje'], 0) . '%',
                        ];
                    }
                }
                $export = new InductionExcelReportExport(collect($data), collect($cabecera));
                break;
            case 3:
                $export = new InductionExcelReportExport(collect($data), collect($cabecera));
                break;
            case 4:
                $headerKeys = ["intento", "nombre", "empresa", "codigo", "cargo", "start_date", "id_service"];
                $headerMap = [
                    "codigo" => "Documento de identidad",
                    "nombre" => "Datos del Trajador",
                    "empresa" => "Empresa",
                    "cargo" => "Cargo",
                ];
                if ($induction->alias == 'Aislamiento y bloqueo de energías') {
                    $detailKeys = ["start_date", "maxNota", "EPPs", "Equipos de bloqueo", "Aislamiento", "Bloqueo y tarjeteo"];

                    $detailMap = [
                        "start_date" => "Fecha de inicio",
                        "EPPs" => "EPPs",
                        "Equipos de bloqueo" => "Equipos de bloqueo",
                        "Aislamiento" => "Aislamiento",
                        "Bloqueo y tarjeteo" => "Bloqueo y tarjeteo",
                        "maxNota" => "Nota"
                    ];
                } elseif ($induction->alias == 'Seguridad de Procesos') {

                    $detailKeys = [
                        "start_date",
                        "EPPs",
                        "Equipos de bloqueo",
                        "Aislamiento",
                        "Bloqueo y tarjeteo",
                        "Derrame de crudo",
                        "Fuga de agua",
                        "Deterioro de tuberías",
                        "Desgaste de estructuras",
                        "Personaje de caída",
                        "Derrame de barriles",
                        "Camión de grua",
                        "Ingreso al tanque",
                        "maxNota"
                    ];
                    $detailMap = [
                        "start_date" => "Fecha de inicio",
                        "EPPs" => "EPPs",
                        "Equipos de bloqueo" => "Equipos de bloqueo",
                        "Aislamiento" => "Aislamiento",
                        "Bloqueo y tarjeteo" => "Bloqueo y tarjeteo",
                        "Derrame de crudo" => "Derrame de crudo",
                        "Fuga de agua" => "Fuga de agua",
                        "Deterioro de tuberías" => "Deterioro de tuberías",
                        "Desgaste de estructuras" => "Desgaste de estructuras",
                        "Personaje de caída" => "Personaje de caída",
                        "Derrame de barriles" => "Derrame de barriles",
                        "Camión de grua" => "Camión de grua",
                        "Ingreso al tanque" => "Ingreso al tanque",
                        "maxNota" => "Nota"
                    ];
                } else {
                    $detailKeys = [
                        "start_date",
                        "maxNota"
                    ];
                    $detailMap = [
                        "start_date" => "Fecha de inicio",
                        "maxNota" => "Nota"
                    ];
                }
                $data = $this->notaConfipetrolExcel($inductionWorkers, $headerKeys, $detailKeys, $induction->alias, $fecha_inicio, $fecha_fin);
                $export = new ExcelGeneralConfipetrol(collect($data), collect($cabecera), collect($headerMap), collect($detailMap));
                break;
            default:
                break;
        }

        $filename = $cabecera['simulador'] . '_' . date('Y-m-d_H-i-s') . '.xlsx';
        return Excel::download($export, $filename);
    }

    public function notaConfipetrolExcel($inductionWorkers, $headerKeys, $detailKeys, $alias, $fecha_inicio, $fecha_fin)
    {
        $data = [];
        foreach ($inductionWorkers as $worker) {
            if ($alias == 'Aislamiento y bloqueo de energías') {

                $datos = $worker->notaConfipetrolMax(1);
            } elseif ($alias == 'Seguridad de Procesos') {
                $datos = $worker->notaConfipetrolProcesos(1);
            } else {
                $datos = $worker->notaConfipetrolAnalisis(1);
            }
            $intentos = $worker->num_report;

            $cabecera = array_intersect_key($datos, array_flip($headerKeys));

            if ($intentos) {
                $arr_detalle = [];
                $detalle = array_intersect_key($datos, array_flip($detailKeys));

                if ($fecha_inicio !== null && $fecha_fin !== null) {
                    if (isset($detalle['start_date']) && $fecha_inicio <= $detalle['start_date'] && $detalle['start_date'] <= $fecha_fin) {
                        $detalle['start_date'] = date('d-m-Y ', strtotime($detalle['start_date']));
                        $arr_detalle[] = $detalle;
                    }
                } else {
                    $detalle['start_date'] = isset($detalle['start_date']) ? date('d-m-Y ', strtotime($detalle['start_date'])) : null;
                    $arr_detalle[] = $detalle;
                }

                if ($intentos > 1) {
                    for ($i = 2; $i <= $intentos; $i++) {
                        if ($alias == 'Aislamiento y bloqueo de energías') {
                            $datos = $worker->notaConfipetrolMax($i);
                        } elseif ($alias == 'Seguridad de Procesos') {
                            $datos = $worker->notaConfipetrolProcesos($i);
                        } else {
                            $datos = $worker->notaConfipetrolAnalisis($i);
                        }
                        $detalle = array_intersect_key($datos, array_flip($detailKeys));

                        if ($fecha_inicio !== null && $fecha_fin !== null) {
                            if (isset($detalle['start_date']) && $fecha_inicio <= $detalle['start_date'] && $detalle['start_date'] <= $fecha_fin) {
                                $detalle['start_date'] = date('d-m-Y ', strtotime($detalle['start_date']));
                                $arr_detalle[] = $detalle;
                            }
                        } else {
                            $detalle['start_date'] = isset($detalle['start_date']) ? date('d-m-Y ', strtotime($detalle['start_date'])) : null;
                            $arr_detalle[] = $detalle;
                        }
                    }
                }
                $cabecera['detalle'] = $arr_detalle;
            }

            $data[] = $cabecera;
        }

        return $data;
    }

    public function generarReportePDF($id_induction_worker)
    {
        $induction_worker = InductionWorker::find($id_induction_worker);
        $worker = Worker::find($induction_worker->id_worker);
        $induction = Induction::find($induction_worker->id_induction);
        $detail_induction_worker = DetailInductionWorker::where('induction_worker_id', $induction_worker->id)
            ->orderBy('time', 'asc')
            ->get();

        // Cargar los datos necesarios para el PDF en el arreglo $data
        $casosTotales = $induction_worker->case_count;
        $casosBuenos = $detail_induction_worker->filter(function ($detail) {
            return floatval($detail->identified) != 0;
        })->count();
        $casosMalos = 8 - $casosBuenos;

        $data = [
            'induction_worker' => $induction_worker,
            'worker' => $worker,
            'induction' => $induction,
            'imagen' => "https://quickchart.io/chart?c={type:'doughnut', data:{datasets:[{data:[$casosBuenos,$casosMalos],backgroundColor:['rgb(32,164,81)','rgb(255,0,0)'],}],labels:['Encontrado', 'No encontrados'],},options:{title:{display:false},plugins: { datalabels: { color: 'white' } },},}",
            'detail_induction_worker' => $detail_induction_worker,
            'casosTotales' => $casosTotales,
            'casosBuenos' => $casosBuenos,
            'casosMalos' => $casosMalos,
            'nota' => $induction_worker->Ponderado,
            'categoria' => $induction_worker->Categoria,
            'porcentaje' => $induction_worker->Porcentaje,
        ];

        // Generate PDF
        $pdf = PDF::loadView('ReportesFormatos.asistenciaPDF', $data);

        return $pdf;
    }

    public function descargar_asistencia_zip(Request $request, $id_induction)
    {
        // Recupera los trabajadores de la inducción para la inducción dada
        $induction_workers = InductionWorker::where('id_induction', $id_induction)
            ->where('status', '1')
            ->where('num_report', '>', 0)
            ->get();
        // Crea el directorio principal para almacenar los informes
        $reportDir = 'reportes';
        Storage::makeDirectory($reportDir);

        // Crea un directorio para la inducción específica
        $inductionDir = $reportDir . '/' . $id_induction;
        Storage::makeDirectory($inductionDir);
        // Genera y almacena los PDFs para cada trabajador de la inducción
        foreach ($induction_workers as $induction_worker) {
            $pdf = $this->generarPDFISem($induction_worker->id, $induction_worker->num_report, 'Evaluación');
            $pdfFileName = 'reporte_' . $induction_worker->worker->user->doi . '.pdf';
            Storage::put($inductionDir . '/' . $pdfFileName, $pdf->output());
        }

        // Crea un archivo ZIP
        $tempZipPath = tempnam(sys_get_temp_dir(), 'reportes');
        $zipFileName = basename($tempZipPath) . '.zip';
        $zipFilePath = storage_path('app/' . $reportDir . '/' . $zipFileName);

        $zip = new ZipArchive;
        if ($zip->open($zipFilePath, ZipArchive::CREATE) === true) {
            // Añade cada PDF al archivo ZIP
            foreach (Storage::files($inductionDir) as $file) {
                $zip->addFile(Storage::path($file), basename($file));
            }

            $zip->close();
        }

        // Elimina el directorio de la inducción
        Storage::deleteDirectory($inductionDir);

        // Descarga el archivo ZIP
        return response()->download($zipFilePath);
    }



    public function reportealumno(Request $request)
    {
        return view('Supervisor.reportealumno');
    }
    public function reportealumnodetail(Request $request)
    {

        try {
            $workerIds = Worker::where('code_worker', 'LIKE', '%' . '-' . $request->doi)
                ->where('id_company', session('id_company'))
                ->pluck('id');

            $inductions = InductionWorker::whereIn('id_worker', $workerIds)->get();


            $inductionsData = [];
            foreach ($inductions as $induction) {
                $result = DB::table('detail_induction_workers')
                    ->select(DB::raw('COALESCE(MAX(report) , 0) AS result'))
                    ->where('induction_worker_id', $induction->id)
                    ->where('entrenamiento', '1')
                    ->first();

                $nuevoIntento = $result->result;
                $inductionData = [
                    'id_induction_workers' => $induction->id,
                    'date_start' => $induction->induction->date_start . ' ' . $induction->induction->time_start,
                    'date_end' => $induction->induction->date_end . ' ' . $induction->induction->time_end,
                    'num_report' => $induction->num_report,
                    'num_report_entenamiento' =>  $nuevoIntento,
                    'name_taller' => $induction->induction->alias,
                ];
                $intentos = [];
                for ($i = 1; $i <= $induction->num_report; $i++) {
                    $data = $induction->detailsByReportAndTraining($i, 'evaluacion')->first();
                    if ($data) {

                        $start_date = $data->start_date;
                        $end_date = $data->end_date;

                        if (session('id_company') == 5) {
                            $json = json_decode($data->json, true);
                            $start_date = $json['startDate'] ?? '-';
                            $end_date = $json['endDate'] ?? '-';
                        }

                        $intentos[] = [
                            'intento' => $data->report,
                            'note' => $data->note,
                            'note_reference' => $data->note_reference,
                            'date_start' => $start_date,
                            'date_end' => $end_date,
                            'modo' => 'Evaluación',
                            'id' => $data->id
                        ];
                    } else {
                    }
                }
                for ($i = 1; $i <= $nuevoIntento; $i++) {
                    $data = $induction->detailsByReportAndTraining($i, 'entrenamiento')->first();
                    $start_date = $data->start_date;
                    $end_date = $data->end_date;

                    if (session('id_company') == 5) {
                        $json = json_decode($data->json, true);
                        $start_date = $json['startDate'] ?? '-';
                        $end_date = $json['endDate'] ?? '-';
                    }
                    $intentos[] = [
                        'intento' => $data->report,
                        'note' => $data->note,
                        'note_reference' => $data->note_reference,
                        'date_start' => $start_date,
                        'date_end' => $end_date,
                        'modo' => 'Entrenamiento',
                        'id' => $data->id
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
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
