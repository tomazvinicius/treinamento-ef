@extends('layouts.main')
@section('title', 'Leninha Doceria Artesanal')
@section('navbar')
@section('content')

<div id="products-container" class="col-md-12">
    <div class="container">
        <div id="cards-container" class="row">
            @foreach ($produtos as $produto)
                <div class="card col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="card-body">
                        <h5 class="card-nome-{{ $produto->id }}">{{$produto->nome}}</h5>
                        <p class="d-none card-preco-{{ $produto->id }}">{{$produto->preco}}</p>
                        <p class="d-none card-descricao-{{ $produto->id }}">{{$produto->descricao}}</p>
                        <img src="{{ asset($produto->imagem) }}" id="imagemProduto-{{ $produto->id }}" alt="" class="img-fluid">
                        <button class="btn btn-primary saiba-mais" data-produto="{{ $produto->id }}">Saiba mais</button>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<script>
    $('.saiba-mais').on('click', function() {
        let id = $(this).data('produto');

        let nome      = $('.card-nome-' + id).text();
        let preco     = $('.card-preco-' + id).text();
        let descricao = $('.card-descricao-' + id).text();
        let imagem;
        alert('Nome: ' + nome + '/Preço; ' + preco + '/Descricao: ' + descricao);
    });
</script>
@endsection