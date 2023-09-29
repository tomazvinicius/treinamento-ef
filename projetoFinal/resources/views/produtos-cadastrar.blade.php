@extends('layouts.main')
@section('title', 'Leninha Doceria Artesanal')
@section('content')

<div id="event-create-container" class="col-lg-6 col-md-8 col-sm-10 col-xs-12 offset-lg-3 offset-md-2 offset-sm-1 offset-xs-0">
    <h1 class="text-center titulo mb-4">Cadastre seu produto</h1>
    <form action="{{ route('produto.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group mt-3">
            <label for="nome">Nome:</label>
            <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome do produto">
        </div>
        <div class="form-group mt-3">
            <label for="preco">Preço:</label>
            <input type="text" class="form-control" id="preco" name="preco" placeholder="Preço do produto">
        </div>
        <div class="form-group mt-3">
            <label for="descricao">Descrição:</label>
            <textarea name="descricao" id="descricao" class="form-control" placeholder="Informe algo adicional:"
                style="resize: none;"></textarea>
        </div>
        <div class="form-group row mt-3 ">
            <label for="imagem" class="px-0">Imagem:</label>
            <input type="file" id="imagem" name="imagem" class="form-control-file px-0">
        </div>
        <div class="d-flex flex-column align-items-center mt-3">
            <input type="submit" class="btn btn-primary" value="Criar produto">
        </div>
    </form>
</div>
@endsection
