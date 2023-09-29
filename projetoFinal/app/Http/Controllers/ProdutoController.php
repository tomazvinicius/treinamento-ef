<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;
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
        return view('produtos-cadastrar', ['produtos' => $produtos]);
    }

    // Armazenar dados.
    public function store(Request $request)
    {
        $produto = new Produto;

        $produto->nome = $request->nome;
        $produto->preco = $request->preco;
        $produto->descricao = $request->descricao;

        if ($request->hasFile('imagem') && $request->file('imagem')->isValid()) {
            $produto->imagem = $request->file('imagem')->store('imagens/produtos');
        }

        $produto->save();

        return redirect(route('produto.read'));
    }

    // Cards dos produtos
    public function read()
    {
        $produtos = Produto::all();
        return view('produtos-exibir', ['produtos' => $produtos]);

    }

    // Dashboard dos produtos
    public function dashboard()
    {
        $produtos = Produto::all();
        return view('dashboard', ['produtos' => $produtos]);
    }
    // Editar produtos
    public function edit(Produto $produto)
    {

        return view('produtos-editar', ['produtos' => $produto]);
    }

    //  Alterar produtos
    public function update(Request $request, Produto $produto)
    {
        $produto->nome = $request->nome;
        $produto->preco = $request->preco;
        $produto->descricao = $request->descricao;

        if ($request->hasFile('imagem') && $request->file('imagem')->isValid()) {
            $produto->imagem = $request->file('imagem')->store('imagens/produtos');
        }

        $produto->save();
        return redirect()->route('produto.dashboard');

    }

    public function destroy(Produto $produto)
    {
        if ($produto->delete()) {
            return redirect()->route('produto.dashboard')->with('msg', 'Produto excluído com sucesso');
        } else {
            return redirect()->route('produto.dashboard')->with('error', 'Erro ao excluir o produto');
        }
    }
    public function gerarPDF()
    {
        $produtos = Produto::all(); // Substitua 'Produto' pelo nome do seu modelo

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf', compact('produtos'));

        return $pdf->download('produtos.pdf');
    }
}