<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdutoController;

// Home
Route::get('/', [ProdutoController::class, 'index'])->name('produto.home');

Route::get('/produtos/cadastrar', [ProdutoController::class, 'create'])->name('produto.create');
Route::post('/produtos', [ProdutoController::class, 'store'])->name('produto.store');

Route::get('/produtos', [ProdutoController::class, 'read'])->name('produto.read');

Route::get('/produtos/dashboard', [ProdutoController::class, 'dashboard'])->name('produto.dashboard');

Route::get('/produtos/editar/{produto}', [ProdutoController::class, 'edit'])->name('produto.edit');

Route::patch('/produtos/update/{produto}', [ProdutoController::class, 'update'])->name('produto.update');

Route::delete('/produtos/delete/{produto}', [ProdutoController::class, 'destroy'])->name('produto.destroy');

Route::get('/gerar-pdf', [ProdutoController::class, 'gerarPDF']);