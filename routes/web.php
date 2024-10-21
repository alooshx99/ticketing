<?php

use Illuminate\Support\Facades\Route;

//Route::get('/', function () {
//    return view('welcome');
//});


Route::get('/', function () {
    return view('admin');
});


Route::get('/1', function () {
    return view('index');
});
