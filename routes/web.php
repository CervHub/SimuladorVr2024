<?php

use Illuminate\Support\Facades\Route;

// Controladores para Super Administrador
use App\Http\Controllers\SuperAdmin\SuperAdminController;

// Controladores para Administrador
use App\Http\Controllers\Administrator\AdminController;

// Controladores para Entrenador
use App\Http\Controllers\Administrator\SupervisorController;

// Controladores para User
use App\Http\Controllers\User\UserController;

//Authentication
use App\Http\Controllers\AuthenticationController;
use PhpOffice\PhpSpreadsheet\Style\Supervisor;

use App\Http\Controllers\ApiIsemController;
use App\Http\Controllers\ProfileController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::post('loginSubmit', [AuthenticationController::class, 'loginSubmit'])->name('loginSubmit');
Route::get('logout', [AuthenticationController::class, 'logout'])->name('logout');

// BEGIN Rutas para SUPER administrador
Route::middleware(['superadmin', 'auth'])->group(function () {
    Route::get('superadmin/dashboard', [SuperAdminController::class, 'index'])->name('superadministrador');
    Route::get('superadmin/empresa', [SuperAdminController::class, 'empresa'])->name('superadministrador.empresa');
    Route::get('superadmin/reporte', [SuperAdminController::class, 'reporte'])->name('superadministrador.reporte');
    Route::post('superadmin/createcompany', [SuperAdminController::class, 'createcompany'])->name('createcompany');
    Route::post('superadmin/editarcompany', [SuperAdminController::class, 'editarcompany'])->name('editarcompany');
    Route::post('superadmin/details', [SuperAdminController::class, 'details'])->name('details');
    Route::post('superadmin/eliminar', [SuperAdminController::class, 'eliminar'])->name('eliminarCompany');
    Route::get('talleres/{id_company}', [SuperAdminController::class, 'tallercompany'])->name('superadministrador.taller');
    Route::post('talleres/create', [SuperAdminController::class, 'createtaller'])->name('superadministrador.create.taller');
    Route::post('talleres/details', [SuperAdminController::class, 'detailstalleres'])->name('detailstalleres');
    Route::post('talleres/editar', [SuperAdminController::class, 'editartaller'])->name('superadministrador.editar.taller');
    Route::get('talleres', [SuperAdminController::class, 'dashboardtalleres'])->name('superadministrador.taller.dashboard');
    Route::post('talleres/createtallercompanies', [SuperAdminController::class, 'createtallercompanies'])->name('superadministrador.createtallercompanies');
    Route::post('talleres/details2', [SuperAdminController::class, 'detailstalleres2'])->name('detailstalleres2');
    Route::post('talleres/editar/company', [SuperAdminController::class, 'editartallercompany'])->name('superadministrador.editar.taller.company');
});

// BEGIN Rutas para Administrador
Route::middleware(['admin'])->group(function () {
    Route::get('administrador/dashboard', [AdminController::class, 'index'])->name('administrador');
    Route::get('administrador/servicio', [AdminController::class, 'servicio'])->name('administrador.servicio');
    Route::get('administrador/reporte', [AdminController::class, 'reporte'])->name('administrador.reporte');
    Route::get('administrador/entrenador', [AdminController::class, 'entrenador'])->name('administrador.entrenador');
    Route::post('administrador/crearentrenador', [AdminController::class, 'crearentrenador'])->name('administrador.crearentrenador');
    Route::post('administrador/editarentrenador', [AdminController::class, 'editarentrenador'])->name('administrador.editarentrenador');
    Route::post('administrador/deletearentrenador', [AdminController::class, 'deletearentrenador'])->name('administrador.deletearentrenador');
    Route::post('administrador/detalle', [AdminController::class, 'detalle'])->name('administrador.detalle');
    Route::post('administrador/updatecompany', [AdminController::class, 'updateCompany'])->name('administrador.updatecompany');
    Route::post('administrador/updatecolormobile', [AdminController::class, 'updatecolormobile'])->name('updatecolormobile');
    Route::post('administrador/updatecolordesktop', [AdminController::class, 'updatecolordesktop'])->name('updatecolordesktop');
});

//BEGIN Rutas para Entrenador
Route::middleware(['entrenador'])->group(function () {
    Route::get('entrenador/dashboard', [SupervisorController::class, 'index'])->name('entrenador');
    Route::get('entrenador/servicio', [SupervisorController::class, 'servicio'])->name('entrenador.servicio');
    Route::get('entrenador/reporte', [SupervisorController::class, 'reporte'])->name('entrenador.reporte');
    Route::post('entrenador/crearservicio', [SupervisorController::class, 'crearservicio'])->name('entrenador.crearservicio');
    Route::post('entrenador/detalle', [SupervisorController::class, 'detalle'])->name('entrenador.detalle');
    Route::post('entrenador/editarservicio', [SupervisorController::class, 'editarservicio'])->name('entrenador.editarservicio');
    Route::post('entrenador/eliminarservicio', [SupervisorController::class, 'eliminararservicio'])->name('entrenador.eliminarservicio');
    Route::get('matricula/{id_service}', [SupervisorController::class, 'matricula'])->name('entrenador.matricula');
    Route::post('matricula/crearuser', [SupervisorController::class, 'crearuser'])->name('matricula.crearuser');
    Route::post('matricula/edituser', [SupervisorController::class, 'edituser'])->name('matricula.edituser');
    Route::post('matricula/eliminaruser', [SupervisorController::class, 'eliminaruser'])->name('matricula.eliminaruser');
    Route::post('matricula/cargamasiva', [SupervisorController::class, 'cargamasiva'])->name('matricula.cargamasiva');
    Route::get('induccion', [SupervisorController::class, 'induccion'])->name('entrenador.induccion');
    Route::post('induccion/eliminar', [SupervisorController::class, 'induccioneliminar'])->name('entrenador.induccion.eliminar');
    Route::post('inducction/create', [SupervisorController::class, 'induccioncreate'])->name('entrenador.crearinduction');
    Route::post('induction/search', [SupervisorController::class, 'induccionsearch'])->name('entrenador.search.induction');
    Route::post('induction/update', [SupervisorController::class, 'induccionupdate'])->name('entrenador.update.induction');
    Route::get('evaluacion/{id_induction}', [SupervisorController::class, 'evaluacion'])->name('entrenador.evaluacion');
    Route::post('evaluacion/searchworker', [SupervisorController::class, 'searchworker'])->name('entrenador.search.worker');
    Route::post('evaluacion/searchworkerservice', [SupervisorController::class, 'searchworkerservice'])->name('entrenador.search.worker.service');
    Route::post('evaluacion/searchworkerdoi', [SupervisorController::class, 'searchworkerdoi'])->name('entrenador.search.workerdoi');
    Route::post('evaluacion/searchworkerdoiid', [SupervisorController::class, 'searchworkerdoiid'])->name('entrenador.search.worker.doi');
    Route::post('inscribir', [SupervisorController::class, 'inscribir'])->name('entrenador.inscribir');
    Route::get('formatomasivoinduction', [SupervisorController::class, 'descargarinductionformato'])->name('induction.formato');
    Route::get('formatomasivomatricula', [SupervisorController::class, 'descargarmasivoformato'])->name('induction.formato.masivo');
    Route::post('induction/cargamasiva', [SupervisorController::class, 'cargamasivainduction'])->name('induction.cargamasiva');
    Route::post('induction/eliminar', [SupervisorController::class, 'eliminarinductionworker'])->name('entrenador.eliminar.induction.worker');
    // Ruta para descargar asistencia
    Route::get('descargar_asistencia/{id_induction}/{fecha_inicio}/{fecha_fin}', [SupervisorController::class, 'descargar_asistencia'])->name('descargar_asistencia_pdf');
    Route::get('descargar_asistencia_excel/{id_induction}/{fecha_inicio}/{fecha_fin}', [SupervisorController::class, 'descargar_asistencia_excel'])->name('descargar_asistencia_excel');

    // Ruta para descargar Zip de reportes de notas individuales
    Route::get('descargar_zip_notas/{id_induction}', [SupervisorController::class, 'descargar_zip_notas'])
        ->name('descargar_zip_notas');

    // Ruta para descargar Reportes generales de notas
    Route::get('generar_reporte_notas/{id_induction}', [SupervisorController::class, 'generar_reporte_notas'])
        ->name('generar_reporte_notas');

    Route::get('reporte/alumno', [SupervisorController::class, 'reportealumno'])->name('reporte.alumno');
    Route::post('reporte/alumno/detail', [SupervisorController::class, 'reportealumnodetail'])->name('reportealumnodetail');
});

Route::get('profile', [ProfileController::class, 'perfil'])->name('perfil');
Route::post('profile/update', [ProfileController::class, 'update'])->name('updateperfil');
Route::post('password/update', [ProfileController::class, 'updatepassword'])->name('updatepassword');

Route::get('isem/v1/insertnota/{json}', [ApiIsemController::class, 'insertnota']);
Route::get('isem/v1/insertcasos/{json}', [ApiIsemController::class, 'insertcasos']);
Route::get('isem/v1/{dni}', [ApiIsemController::class, 'induction']);

Route::get('view/pdf/{id_induction_worker}', [SupervisorController::class, 'visualizar_reporte_notas'])
    ->name('view.pdf');


use App\Http\Controllers\ReporteController;

Route::get('imagen/{porcentaje}', [ReporteController::class, 'generarImagen'])->name('imagen.generar');

// Begin Rutas para User
Route::get('user', [UserController::class, 'index'])->name('user');
