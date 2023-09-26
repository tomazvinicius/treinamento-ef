<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdutoController;


Route::get('/', [ProdutoController::class, 'index']);
Route::get('/produtos/ler', [ProdutoController::class, 'read']);
Route::get('/produtos/cadastrar', [ProdutoController::class, 'create']);
// Route::Post("/")