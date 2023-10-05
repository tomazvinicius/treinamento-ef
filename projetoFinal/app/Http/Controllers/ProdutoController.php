<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
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

    // Armazenar dados.
    public function create()
    {
        $produtos = Produto::all();
        return view('produtos/create', ['produtos' => $produtos]);
    }

    public function store(Request $request)
    {

        $rules = [
            'imagem' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'nome' => 'required|max:255',
            'preco' => 'required',
            'kg' => 'required',
            'descricao' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect(route('produto.create'))
                ->withErrors($validator)
                ->withInput();
        }

        $produto = Produto::create([
            'imagem' => $request->file('imagem')->storePublicly('produtos', 'public'),
            'nome' => mb_strtoupper($request->nome),
            'preco' => str_replace(',', '.', str_replace('.', '', $request->preco)),
            'kg' => str_replace(',', '.', $request->kg),
            'descricao' => $request->descricao,
        ]);

        return redirect()->route('produto.index')->with('success', "Produto: {$produto->nome} cadastrado com sucesso!");
    }

    // Editar produtos
    public function edit(Produto $produto)
    {
        return view('produtos/edit', ['produtos' => $produto]);
    }

    public function update(Request $request, Produto $produto)
    {
        $request->validate([
            'nome' => 'required|max:255',
            'preco' => 'required',
            'kg' => 'required',
            'descricao' => 'required',
            'imagem' => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $produto->nome = mb_strtoupper($request->nome);
        $produto->preco = str_replace(',', '.', str_replace('.', '', $request->preco));
        $produto->descricao = $request->descricao;
        $produto->kg = str_replace(',', '.', $request->kg);

        if ($request->hasFile('imagem') && $request->file('imagem')->isValid()) {
            $produto->imagem = $request->file('imagem')->storePublicly('produtos', 'public');
        }

        $produto->save();

        return redirect()->route('produto.index')->with('success', "Produto: {$produto->nome} atualizado com sucesso!");
    }

    public function destroy(Produto $produto)
    {
        if ($produto->delete()) {
            Storage::delete("public/{$produto->imagem}");
            return redirect()->route('produto.index')->with('success', 'Produto excluído com sucesso');
        } else {
            return redirect()->route('produto.index')->with('error', 'Erro ao excluir o produto');
        }
    }

    public function gerarPDF(Request $request)
    {
        $ids = $request->get('ids');

        if (!$ids)
            return abort(404);

        $produtos = Produto::whereIn('id', $ids)
            ->orderBy('nome')
            ->get()
            ->map(function ($p) {
                $extension = pathinfo($p->imagem, PATHINFO_EXTENSION);
                $dataImage = "data:image/{$extension};base64,";

                return (object) [
                    'id' => $p->id,
                    'nome' => $p->nome,
                    'descricao' => $p->descricao,
                    'nome_formatado' => $p->nome_formatado,
                    'kg' => $p->kg,
                    'preco' => $p->preco,
                    'logo' => $dataImage . base64_encode(file_get_contents(public_path("storage/{$p->imagem}")))
                ];
            });

        $pdf = Pdf::loadView('produtos/show', compact('produtos'));

        // return $pdf->stream('produtos.pdf');
        return $pdf->download('produtos.pdf');
    }
}