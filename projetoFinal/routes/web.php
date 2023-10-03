<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdutoController;


Route::get('/produtos/cadastrar', [ProdutoController::class, 'create'])->name('produto.create');
Route::post('/produtos', [ProdutoController::class, 'store'])->name('produto.store');

Route::get('/produtos', [ProdutoController::class, 'read'])->name('produto.read');

Route::get('/', [ProdutoController::class, 'index'])->name('produto.index');

Route::get('/produtos/editar/{produto}', [ProdutoController::class, 'edit'])->name('produto.edit');

Route::patch('/produtos/update/{produto}', [ProdutoController::class, 'update'])->name('produto.update');

Route::delete('/produtos/delete/{produto}', [ProdutoController::class, 'destroy'])->name('produto.destroy');

Route::get('/gerar-pdf', [ProdutoController::class, 'gerarPDF'])->name('produto.pdf');