<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SendController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Auth::routes();
Route::group(['middleware' => ['auth']], function() {

    Route::resource('roles', App\Http\Controllers\RoleController::class);
    Route::resource('users', App\Http\Controllers\UserController::class);
    Route::get('users/status/{user_id}/{status_code}', [App\Http\Controllers\UserController::class, 'updateStatus'])->name('users.status.update');
    Route::resource('projects', App\Http\Controllers\ProjectController::class);
    Route::resource('avances', App\Http\Controllers\AvanceController::class);
    Route::post('/avances/save-comment', 'App\Http\Controllers\AvanceController@save_comment')->name('save_comment');
    Route::post('/indicators/tiempo-promedio-primer-avance', 'App\Http\Controllers\IndicatorController@GetIndicadorProjectPrimerAvanceTiempoPromedio')->name('tiempo_promedio_primer_avance');
    Route::resource('send', App\Http\Controllers\SendController::class);
    Route::get('/send', 'App\Http\Controllers\SendController@send')->name('send');
    Route::post('/send', 'App\Http\Controllers\SendController@sendPost')->name('sendPost');
    Route::get('/indicators', 'App\Http\Controllers\IndicatorController@indicator')->name('indicator');
    Route::post('/indicators', 'App\Http\Controllers\IndicatorController@indicatorPost')->name('indicatorPost');
    Route::get('/reports', 'App\Http\Controllers\ReportController@report')->name('report');
    Route::post('/reports', 'App\Http\Controllers\ReportController@reportPost')->name('reportPost');
    Route::get('/reports/export/', 'App\Http\Controllers\ReportController@export');
    
});
