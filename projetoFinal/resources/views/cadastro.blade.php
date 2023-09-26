@extends('layouts.main')
@section('title', 'Leninha Doceria Artesanal')
@section('navbar')
@section('content')

    <div id="produto-create-container" class="col-md-6 offset-md-3 ">
        <form action="/cadastrar" method="POST">
        
        <div class="form-group">
            <label for="nome">Nome:</label>
            <input type="text" class="form-control" id="nome" placeholder="Nome do produto">
        </div>
        <div class="form-group">
            <label for="preco">Preco:</label>
            <input type="number"  step=0.01 class="form-control" id="preco" placeholder="Preco do produto">
        </div>
        <div class="form-group">
            <label for="descricao">Descrição:</label>
            <textarea class="form-control"   placeholder="Descrição do produto" id="descricao" cols="2" rows="5"></textarea>
        </div>
        <input type="text" class="btn btn-primary" value="Cadastrar produto">
        </form>
    </div>
@endsection





