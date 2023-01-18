<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\http\Controllers\DosenController;
use App\http\Controllers\HariController;
use App\http\Controllers\JamController;
use App\http\Controllers\WktTdkBersediaController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\Penjadwalan;
use App\Http\Controllers\GetJadwal;
use App\Http\Controllers\MatakuliahController;
use App\Http\Controllers\RuangController;
use App\Http\Controllers\PengampuController;
use App\Http\Controllers\test;


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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//api auth
Route::post('/register', [RegisterController::class, 'register']);
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth:api');

//api data
Route::resource('/waktu_tidak_bersedia', WktTdkBersediaController::class)->middleware('auth:api');
Route::resource('/dosen', DosenController::class)->middleware('auth:api');
Route::resource('/jam', JamController::class)->middleware('auth:api');
Route::resource('/matakuliah', MatakuliahController::class)->middleware('auth:api');
Route::resource('/ruang', RuangController::class)->middleware('auth:api');
Route::resource('/hari', HariController::class)->middleware('auth:api');
Route::resource('/pengampu', PengampuController::class)->middleware('auth:api');

//api penjadwalan
Route::resource('/getjadwal', GetJadwal::class)->middleware('auth:api');
Route::post('/penjadwalan', [Penjadwalan::class, 'penjadwalan'])->middleware('auth:api');
Route::get('/dosenView', [DosenController::class, 'dosenView']);
Route::get('/ruangView', [RuangController::class, 'ruangView']);

//test
Route::resource('/test', test::class);
