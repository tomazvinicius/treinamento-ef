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

    public function store(Request $request)
    {

        $produto = new Produto;

        $produto->nome = $request->nome;
        $produto->preco = $request->preco;
        $produto->descricao = $request->descricao;

        if ($request->hasFile('imagem') && $request->file('imagem')->isValid()) {
            $requestImage = $request->imagem;
            $extension = $requestImage->getClientOriginalExtension(); // Corrigido

            $imageName = md5($requestImage->getClientOriginalName() . strtotime("now")) . "." . $extension; // Corrigido

            $requestImage->move(public_path('/img'), $imageName);

            $produto->imagem = $imageName;
        }


        $produto->save();

        return redirect('/produtos/ler');
    }

    public function read()
    {
        $produtos = Produto::all();
        return view('produtos', ['produtos' => $produtos]);

    }

    public function table()
    {
        $produtos = Produto::all();
        return view('tabela-a', ['produtos' => $produtos]);
    }

    // public function destroy($id)
    // {
    //     Produto::findFail($id)->delete();

    //     return redirect('/produtos/ler')->with('msg', "Produto excluído com sucesso");
    // }

    public function edit(Produto $produto)
    {

        return view('editar', ['produtos' => $produto]);
    }

    public function update(Request $request, Produto $produto)
    {
        return redirect()->route('produto.table');

        dd($request->all());
    }
}