<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ApiExternaController;

// Route::get('/pokemon', function () {
//     return getPokemon('pokemon');
// });

Route::get('pokemon', [ApiExternaController::class, 'getPokemon']);
