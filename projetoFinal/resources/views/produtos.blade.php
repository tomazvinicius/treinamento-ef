@extends('layouts.main')
@section('title', 'Leninha Doceria Artesanal')
@section('navbar')
@section('content')

{{-- <div id="search-container" class="col-md-12">
    <h1>Busque um produto</h1>
    <form action="">
        <input type="text" id="search" name="search" class="form-control" placeholder="Procurar...">
    </form>
</div> --}}

<div id="products-container" class="col-md-12">
    {{-- <h2>Produtos</h2> --}}

    <div id="cards-container" class="row">
        @foreach ($produtos as $produto)
            <div class="card col-md-2">
                <img src="/img/boloMorango.jpg" alt="">
                <div class="card-body">
                    <h5 class="card-nome">{{$produto->nome}}</h5>
                    <p class="card-preco">{{$produto->preco}}</p>
                    <p class="card-descricao">{{$produto->descricao}}</p>
                    <a href="" class="btn btn-primary">Saiba mais</a>
                </div>
            </div>
        @endforeach
    </div>
</div>

@endsection