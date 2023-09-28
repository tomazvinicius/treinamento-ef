@extends('layouts.main')
@section('title', 'Leninha Doceria Artesanal')
@section('navbar')
@section('content')

<div id="event-create-container" class="col-md-6 offset-md-3">
    <h1>Editando seu produto</h1>
    <form action="/produtos/update/{{$produtos->id}}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
      <div class="form-group m-3">
        <label for="nome">Nome:</label>
        <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome do produto" value="{{$produtos->nome}}">
      </div>
      <div class="form-group m-3">
        <label for="preco">Preço:</label>
        <input type="text" class="form-control" id="preco" name="preco" placeholder="Preço do produto" value="{{$produtos->preco}}" >
      </div>
      <div class="form-group m-3">
        <label for="descricao">Descrição:</label>
        <textarea name="descricao" id="descricao" class="form-control" placeholder="Informe algo adicional:">{{$produtos->descricao}}</textarea>
      </div>
      <div class="form-group m-3">
        <label for="imagem">Imagem:</label>
        <input type="file" id="imagem" name="imagem" class="from-control-file">
        <img src="/img/{{$produtos->imagem}}" alt="" class="img-preview">
      </div>
      <input type="submit" class="btn btn-primary m-3" value="Editar produto">
    </form>
  </div>
@endsection