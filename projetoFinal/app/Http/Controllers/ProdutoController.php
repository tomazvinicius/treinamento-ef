<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\Produto;

class ProdutoController extends Controller
{
    public function index()
    {
        $produtos = Produto::all();
        return view('produtos/index', ['produtos' => $produtos]);
    }

    public function create()
    {
        $produtos = Produto::all();
        return view('produtos/create', ['produtos' => $produtos]);
    }

    // Armazenar dados.
    public function store(Request $request)
    {

        $rules = [
            'imagem' => 'image|required',
            'nome' => 'required',
            'preco' => 'required',
            'kg' => 'required',
            'descricao' => 'required|string',
        ];

        $messages = [
            'imagem.required' => 'A imagem é obrigatória.',
            'nome.required' => 'O nome é obrigatório.',
            'preco.required' => 'O preço é obrigatório.',
            'kg.required' => 'O quilograma é obrigatório',
            'descricao.required' => 'A descrição é obrigatória.',
            'imagem.image' => 'O arquivo de imagem não é válido.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect(route('produto.create'))
                ->withErrors($validator)
                ->withInput();
        }
        $produto = Produto::create([
            'imagem' => $request->file('imagem')->store('imagens/produtos'),
            'nome' => $request->nome,
            'preco' => str_replace(',', '.', str_replace('.', '', $request->preco)),
            'kg' => str_replace(',', '.', $request->kg),
            'descricao' => $request->descricao,
        ]);
        $produtos = Produto::all();
        return view('produtos/index', ['produtos' => $produtos]);
    }

    // Editar produtos
    public function edit(Produto $produto)
    {
        return view('produtos/edit', ['produtos' => $produto]);
    }

    // Alterar produtos
    public function update(Request $request, Produto $produto)
    {
        $produto->nome = $request->nome;
        $produto->preco = str_replace(',', '.', str_replace('.', '', $request->preco));
        $produto->descricao = $request->descricao;
        $produto->kg = str_replace(',', '.', $request->kg);

        if ($request->hasFile('imagem') && $request->file('imagem')->isValid()) {
            $produto->imagem = $request->file('imagem')->store('imagens/produtos');
        }

        $produto->save();
        return redirect()->route('produto.index');
    }

    public function destroy(Produto $produto)
    {
        if ($produto->delete()) {
            Storage::delete($produto->imagem);
            return redirect()->route('produto.index')->with('msg', 'Produto excluído com sucesso');
        } else {
            return redirect()->route('produto.index')->with('error', 'Erro ao excluir o produto');
        }
    }

    public function gerarPDF()
    {
        $produtos = Produto::all();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('produtos/show', compact('produtos'));

        return $pdf->download('produtos.pdf');
    }
}