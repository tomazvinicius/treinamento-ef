@extends('layouts.main')
@section('title', 'Leninha Doceria Artesanal')
@section('content')

<div class="table-responsive">
  <table class="table">
    <thead class="table-head">
      <tr>
        <th scope="col">Nome do produto</th>
        <th scope="col">Preço</th>
        <th scope="col">Descrição</th>
        <th scope="col">Ações</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($produtos as $produto)
      <tr>
        <td>{{$produto->nome}}</td>
        <td>{{$produto->preco}}</td>
        <td>{{$produto->descricao}}</td>
        <td>
          <div class="btn-group" role="group">
            <a href="/produtos/editar/{{$produto->id}}" class="btn btn-action-edit"><i class="material-icons">edit</i></a>
            <a href="#"></a>
            <form action="/produtos/delete/{{$produto->id}}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit"  class="btn btn-action-delete"><i class="material-icons">delete</i></button>
          </form>
          </div>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
@endsection