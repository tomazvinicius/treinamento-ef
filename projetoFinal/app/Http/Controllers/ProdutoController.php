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
            'descricao' => $request->descricao,
            'kg' => str_replace(',', '.', $request->kg),
        ]);
        $produtos = Produto::all();
        return view('dashboard', ['produtos' => $produtos]);
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

    // Alterar produtos
    public function update(Request $request, Produto $produto)
    {
        $produto->nome = $request->nome;

        $produto->preco = str_replace(',', '.', str_replace('.', '', $request->preco));
        $produto->kg = str_replace(',', '.', $request->kg);
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
            Storage::delete($produto->imagem);
            return redirect()->route('produto.dashboard')->with('msg', 'Produto excluído com sucesso');
        } else {
            return redirect()->route('produto.dashboard')->with('error', 'Erro ao excluir o produto');
        }
    }

    public function gerarPDF()
    {
        $produtos = Produto::all();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf', compact('produtos'));

        return $pdf->download('produtos.pdf');
    }
}