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
   // Route::delete('users/{id}', [App\Http\Controllers\UserController::class, 'destroy'])->name('users.destroy');
    Route::resource('projects', App\Http\Controllers\ProjectController::class);
    Route::resource('avances', App\Http\Controllers\AvanceController::class);
    Route::resource('send', App\Http\Controllers\SendController::class);
    Route::get('/send', 'App\Http\Controllers\SendController@send')->name('send');
    Route::post('/send', 'App\Http\Controllers\SendController@sendPost')->name('sendPost');

});
