<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AgendamentoController;
use App\Http\Controllers\HorarioController;
use App\Http\Controllers\GrupoAtendimentoController;
use App\Http\Controllers\PontoVacinacaoController;
use App\Http\Controllers\MunicipioController;
use App\Http\Controllers\ChartController;
use App\Http\Controllers\Auth\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('login', [AuthController::class, 'login']);
Route::get('chart', [ChartController::class, 'dataToChart']);
Route::get('chartPorCidade', [ChartController::class, 'dataToChartCidade']);

Route::post('register',  [AuthController::class, 'register']);

Route::group(['middleware' => ['jwt.verify']], function() {
    Route::get('me', [AuthController::class, 'me']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('grupoatendimento/gruposPorIdade', [GrupoAtendimentoController::class, 'gruposAtendimentoByIdade']);
    Route::resource('grupoatendimento', GrupoAtendimentoController::class);
    Route::resource('pontosvacinacao', PontoVacinacaoController::class);
    Route::get('agendamento/check', [AgendamentoController::class, 'checkAgendamento']);
    Route::get('agendamento/comprovante', [AgendamentoController::class, 'comprovante']);
    Route::resource('agendamento', AgendamentoController::class);
    Route::resource('horario', HorarioController::class);
    Route::resource('municipio', MunicipioController::class);
}); 

