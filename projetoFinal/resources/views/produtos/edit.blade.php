@extends('layouts.main')
@section('title', 'Leninha Doceria Artesanal')
@section('content')

<div id="event-create-container" class="col-md-6 offset-md-3">
    <h1 class="text-center titulo mb-4">Edite seu produto</h1>
    <div class="d-flex justify-content-center">
        <form action="/produtos/update/{{$produtos->id}}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            <div class="form-group">
                <label for="nome">Nome:</label>
                <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome do produto" value="{{$produtos->nome}}">
            </div>
            <div class="form-group">
                <label for="preco">Preço:</label>
                <input type="tel" onkeyup="$(this).mask('##,00', {reverse: true})" maxlength="15" class="form-control" id="preco" name="preco" placeholder="Preço do produto" value="{{$produtos->preco_formatado}}" required>
            </div>
            <div class="form-group">
                <label for="preco">Kg:</label>
                <input type="tel" onkeyup="$(this).mask('00,00')"  class="form-control" id="kg" name="kg" placeholder="Kg do produto" value="{{$produtos->kg}}">
            </div>
            <div class="form-group">
                <label for="descricao">Descrição:</label>
                <textarea name="descricao" id="descricao" class="form-control" placeholder="Informe algo adicional:" style="resize: none;">{{$produtos->descricao}}</textarea>
            </div>
            <div class="form-group row">
                <label for="imagem">Escolha uma imagem:</label>
                <input type="file" id="imagem" name="imagem" class="from-control-file">
                <img src="{{asset($produtos->imagem)}}" alt="" class="img-preview mx-auto">
            </div>
            <div class="d-flex justify-content-center mt-3">
                <input type="submit" class="btn botao" value="Salvar">
            </div>
        </form>
    </div>
</div>

@endsection
