@extends('layouts.main')
@section('title', 'Leninha Doceria Artesanal')
@section('navbar')
@section('content')

<div id="products-container" class="col-md-12">
    <div class="container">
        <div id="cards-container" class="row">
            @foreach ($produtos as $produto)
                <div class="card col-lg-3 col-md-4 col-sm-6 mb-4 card-custom ">
                    <div class="card-body text-center d-flex flex-column align-items-center"> <!-- Adicione as classes flex-column e align-items-center aqui -->
                        <h5 class="nome-produto card-nome-{{ $produto->id }}">{{$produto->nome}}</h5>
                        <p class="d-none card-preco-{{ $produto->id }}">R$ {{$produto->preco}}</p>
                        <p class="d-none card-descricao-{{ $produto->id }}">{{$produto->descricao}}</p>
                        <img src="{{ asset($produto->imagem) }}" id="imagemProduto-{{ $produto->id }}" alt="" class="img-fluid">
                        <button type="button" class="btn btn-primary saiba-mais mt-auto" data-bs-toggle="modal" data-bs-target="#produtoModal" data-produto="{{ $produto->id }}">
                            Saiba mais
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

{{-- Modal  --}}
<div class="modal fade" id="produtoModal" tabindex="-1" aria-labelledby="produtoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="produtoModalLabel">Detalhes do Produto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
                <p><strong>Nome:</strong> <span id="modal-nome"></span></p>
                <p><strong>Preço:</strong> <span id="modal-preco"></span></p>
                <p><strong>Descrição:</strong> <span id="modal-descricao"></span></p>
                <img src="" alt="" id="modal-imagem" class="img-fluid">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>
<script>
    $('.saiba-mais').on('click', function() {
        let id = $(this).data('produto');

        let nome      = $('.card-nome-' + id).text();
        let preco     = $('.card-preco-' + id).text();
        let descricao = $('.card-descricao-' + id).text();
        let imagemSrc = $('#imagemProduto-' + id).attr('src');

        // Preencher os dados do modal
        $('#modal-nome').text(nome);
        $('#modal-preco').text(preco);
        $('#modal-descricao').text(descricao);
        $('#modal-imagem').attr('src', imagemSrc);
    });
</script>
@endsection
