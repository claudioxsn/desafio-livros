<?php

use App\Http\Controllers\Api\AssuntoController;
use App\Http\Controllers\Api\AutorController;
use App\Http\Controllers\Api\LivroController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::apiResource('autores', AutorController::class);

Route::apiResource('assuntos', AssuntoController::class);

Route::apiResource('livros', LivroController::class);
