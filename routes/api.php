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



Route::post('/customer/tickets/', [TicketController::class, 'store'])->middleware(['auth:sanctum']);
Route::get('/customer/tickets', [TicketController::class, 'index'])->middleware(['auth:sanctum']);
Route::get('/customer/tickets/{SID}', [TicketController::class, 'show'])->middleware(['auth:sanctum']);
Route::get('/customer/tickets/{SID}/files', [TicketController::class, 'TicketFiles'])->middleware(['auth:sanctum']);
Route::post('/customer/tickets/{SID}/reply', [CustomerReplyController::class, 'reply'])->middleware(['auth:sanctum']);
Route::get('/customer/tickets/reply/{SID}/files', [CustomerReplyController::class, 'ReplyFiles'])->middleware(['auth:sanctum']);


Route::patch('/admin/tickets/{SID}', [AdminTicketController::class, 'update'])->middleware(['auth:sanctum', RoleMiddleware::class . ':admin']);
Route::post('/admin/tickets/{SID}/reply', [AdminReplyController::class, 'reply'])->middleware(['auth:sanctum', RoleMiddleware::class . ':admin']);
Route::get('/admin/tickets', [AdminTicketController::class, 'index'])->middleware(['auth:sanctum', RoleMiddleware::class . ':admin']);
Route::get('/admin/tickets/{SID}', [AdminTicketController::class, 'show'])->middleware(['auth:sanctum', RoleMiddleware::class . ':admin']);



