<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Penjadwalan;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/penjadwalan',[Penjadwalan::class,'penjadwalan']);
Route::get('/kelas',[Test::class,'index']);


