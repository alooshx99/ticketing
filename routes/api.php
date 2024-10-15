<?php

use App\Http\Controllers\Admin\AdminReplyController;
use App\Http\Controllers\auth\LoginController;
use App\Http\Controllers\auth\RegisterController;
use App\Http\Controllers\Customer\CustomerReplyController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\Customer\TicketController;
use App\Http\Controllers\Admin\AdminTicketController;
use App\Http\Middleware\RoleMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/createRole', [RoleController::class, 'createRole']);

Route::post('/register', [RegisterController::class, 'register']);
Route::post('/login', [LoginController::class, 'login']);



Route::post('/customer/tickets/create', [TicketController::class, 'store'])->middleware(['auth:sanctum']);
Route::get('/customer/tickets', [TicketController::class, 'index']);
Route::get('/customer/tickets/{ticket}', [TicketController::class, 'show']);


//Route::middleware(['auth:sanctum', 'role'])->group(function () {
//    Route::patch('/tickets/{ticket}', [TicketController::class, 'update']);
//});

Route::patch('/admin/tickets/update/{ticket}', [AdminTicketController::class, 'update'])->middleware(['auth:sanctum', RoleMiddleware::class . ':admin']);
//Route::patch('/tickets/{ticket}', [TicketController::class, 'update'])->middleware('role:admin');
//Route::patch('/tickets/{ticket}', [TicketController::class, 'update'])->middleware(['auth:sanctum', \App\Http\Middleware\RolesMiddleware::class . 'admin']);


Route::post('/admin/tickets/{ticket}/reply', [AdminReplyController::class, 'reply'])->middleware(['auth:sanctum', RoleMiddleware::class . ':admin']);
Route::get('/admin/tickets/{ticket}/reply/{reply}', [AdminReplyController::class, 'show'])->middleware(['auth:sanctum', RoleMiddleware::class . ':admin']);

Route::post('/customer/tickets/{ticket}/reply', [CustomerReplyController::class, 'reply'])->middleware(['auth:sanctum']);
