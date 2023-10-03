@extends('layouts.main')

@section('title', 'Leninha Doceria Artesanal')

@section('content')
<div class="container">
    <div id="event-create-container" class="col-lg-6 col-md-8 col-sm-10 col-xs-12 offset-lg-3 offset-md-2 offset-sm-1 offset-xs-0 ">
        <h1 class="text-center titulo mb-4 ">Cadastre seu produto</h1>
    
        <form action="{{ route('produto.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group mt-3 row">
                <label class="row" for="nome">Nome:</label>
                <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome do produto" value="{{ old('nome') }}">
                @error('nome')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
    
            <div class="form-group mt-3 row">
                <label class="row"for="preco">Preço:</label>
                <input type="tel" onkeyup="$(this).mask('##,00', {reverse: true})" maxlength="15"  class="form-control " id="preco" name="preco" placeholder="Preço do produto" value="{{ old('preco') }}">
                @error('preco')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
    
            <div class="form-group mt-3 row">
                <label class="row"for="kg">Kg:</label>
                
                <input type="tel" onkeyup="$(this).mask('00,00')"  class="form-control" id="kg" name="kg" placeholder="Kg do produto" value="{{ old('kg') }}">
                @error('kg')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
    
            <div class="form-group mt-3 row">
                <label class="row" for="descricao">Descrição:</label>
                <textarea name="descricao" id="descricao" class="form-control" placeholder="Informe algo adicional:" style="resize: none;">{{ old('descricao') }}</textarea>
                @error('descricao')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
    
            <div class="form-group  mt-3 row">
                <label for="imagem" class="px-0">Selecione uma imagem:</label>
                <input type="file" id="imagem" name="imagem" class="form-control-file px-0 ">
                @error('imagem')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
                @if(old('imagem'))
                    <div class="text-success">Imagem antiga: {{ old('imagem') }}</div>
                @endif
            </div>
    
            <div class="d-flex flex-column align-items-center mt-3 row">
                <input type="submit" class="btn botao row" value="Criar produto">
            </div>
        </form>
    </div>
</div>
@endsection
