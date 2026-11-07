<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InitialController;
use App\Http\Controllers\LoginControler;
use App\Http\Controllers\RecoverPasswordControl;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChefeRedacaoController;
use App\Http\Controllers\ChefeTecnicoController;
use App\Http\Controllers\ChefeEmissoesController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JornalistController;
use App\Http\Controllers\TechniciansController;
use App\Http\Controllers\EdicoesNoticiariosController;
use App\Http\Controllers\EscalaController;
use App\Http\Controllers\FaltaController;
use App\Http\Controllers\FolgaController;
use App\Http\Controllers\SubstituicaoFolgaController;
#Route::get('/', function () {
 #   return view('welcome');
#});





#Public routes
Route::group([], function(){
    Route::get('/', [InitialController::class, 'initial'])->name('initial');
    Route::get('/login0', [LoginControler::class, 'login0'])->name('login0');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::get('/recoverPassword', [RecoverPasswordControl::class, 'recoverPassword'])->name('recoverPassword');
    Route::get('/jornalista', [JornalistController::class, 'jornalista'])->name('jornalista.ver');
    Route::get('/tecnicos_lista', [TechniciansController::class, 'tecnicos_lista'])->name('tecnicos_lista');
    Route::get('/tecnicos', [EscalaController::class, 'tecnicos'])->name('tecnicos');
    Route::get('/locutores', [EscalaController::class, 'locutores'])->name('locutores');
    Route::get('/editores', [EscalaController::class, 'editores'])->name('editores');
    
    Route::get('/folgas', [FolgaController::class, 'index'])->name('folgas.index');

});

#route for authenticated users
Route::middleware('auth')->group(function(){
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    
});

Route::middleware('auth', 'role:chefeRedacao,chefeEmissoes,admin')->group(function(){
    Route::get('/jornalist', [JornalistController::class, 'jornalist'])->name('jornalist');
    Route::post('/jornalista/store', [JornalistController::class, 'store'])->name('jornalist.store');
    Route::get('/escala_loc', [JornalistController::class, 'escala_loc'])->name('escala_loc');
    Route::post('/store_locutores', [JornalistController::class, 'store_locutores'])->name('store_locutores');
    Route::get('/edicoes', [EdicoesNoticiariosController::class, 'edicoes'])->name('edicoes');
    Route::post('/store_edicao', [EdicoesNoticiariosController::class, 'store_edicao'])->name('store_edicao');
    Route::post('/faltas/locutor', [FaltaController::class, 'marcarLocutor'])->name('faltas.marcarLocutor');
    Route::post('/faltas/editor', [FaltaController::class, 'marcarEditor'])->name('faltas.marcarEditor');
    
    Route::get('/folgas/locutor', [FolgaController::class, 'locutores'])->name('folgas.locutores');
    Route::get('/folgas/editor', [FolgaController::class, 'editores'])->name('folgas.editores');
    
    Route::post('/folgas/editor', [FolgaController::class, 'storeEditor'])->name('folgas.storeEditor');
    Route::post('/folgas/locutor', [FolgaController::class, 'storeLocutor'])->name('folgas.storeLocutor');
    

});

#route for technic autentication.
Route::middleware('auth', 'role:chefeTecnico')->group(function(){
    Route::get('/technicians', [TechniciansController::class, 'technicians'])->name('technicians');
    Route::post('/store', [TechniciansController::class, 'store'])->name('techicians.store');
    Route::get('/escala_tecnica', [TechniciansController::class, 'escala_tecnica'])->name('escala_tecnica');
    Route::post('/store_escala', [TechniciansController::class, 'store_escala'])->name('store_escala');
    Route::get('/folgas/tecnico', [FolgaController::class, 'tecnicos'])->name('folgas.tecnicos');

    Route::post('/faltas/tecnico', [FaltaController::class, 'marcarTecnico'])->name('faltas.marcarTecnico');
    Route::post('/folgas/tecnico', [FolgaController::class, 'storeTecnico'])->name('folgas.storeTecnico');

});

#route for authenticated users with specific roles for admin
Route::middleware(['auth','role:admin'])->group(function () {
    Route::get('/user', [UserController::class, 'user'])->name('user');
    Route::post('/user', [UserController::class, 'store'])->name('store');
});    



#route for authenticated users with specific roles
Route::middleware(['auth','role:superadmin'])->group(function () {
    Route::get('/superadmin', [SuperAdminController::class, 'superAdmin'])->name('superAdmin');

});


