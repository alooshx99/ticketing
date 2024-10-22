<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminTicketController;

//Route::get('/', function () {
//    return view('welcome');
//});


//Route::get('/', function () {
//    return view('dashboard');
//});

Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'DashboardData']);
Route::get('/usersList',function (){return view('users');});
Route::get('/editInfo', [App\Http\Controllers\Admin\DashboardController::class, 'DashboardData']);
Route::get('/chat', [App\Http\Controllers\Admin\DashboardController::class, 'DashboardData']);
Route::get('/tickets', [App\Http\Controllers\Admin\DashboardController::class, 'DashboardData']);


Route::get('/1', function () {
    return view('index');
});
