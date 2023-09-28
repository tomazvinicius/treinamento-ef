<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdutoController;


Route::get('/', [ProdutoController::class, 'index']);
Route::get('/produtos/ler', [ProdutoController::class, 'read']);
Route::get('/produtos/tabela', [ProdutoController::class, 'table'])->name('produto.table');

Route::get('/produtos/cadastrar', [ProdutoController::class, 'create']);

Route::get('/produtos/editar/{produto}', [ProdutoController::class, 'edit']);
Route::patch('/produtos/update/{produto}', [ProdutoController::class, 'update'])->name('produto.update');

Route::post('/produtos', [ProdutoController::class, 'store']);