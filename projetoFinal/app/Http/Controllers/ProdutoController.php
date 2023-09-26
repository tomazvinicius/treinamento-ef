<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produto;

class ProdutoController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function create()
    {
        $produtos = Produto::all();
        return view('cadastro', ['produtos' => $produtos]);
    }

    public function read()
    {
        $produtos = Produto::all();
        return view('produtos', ['produtos' => $produtos]);

    }
}