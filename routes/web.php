<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteController;

Route::get('/', function () {
    return view('clientes');
});

Route::controller(ClienteController::class)->group(function () {
    Route::get('/clientes', 'index')->name('index');
    Route::get('/clientes/show', 'show')->name('show');
    Route::post('/clientes/store', 'store')->name('store');
    Route::post('/clientes/update', 'update')->name('update');
    Route::post('/clientes/eliminar', 'destroy')->name('destroy');
});
