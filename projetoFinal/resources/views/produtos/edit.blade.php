@extends('layouts.main')
@section('title', 'Leninha Doceria Artesanal')
@section('content')

<div class="container">
    <div id="event-create-container" class="col-md-6 offset-md-3">
    
        <h1 class="text-center titulo mb-4">Edite seu produto</h1>
    
        <div class="d-flex justify-content-center">
    
            <form class="requires-validation" action="/produtos/update/{{$produtos->id}}" method="POST" enctype="multipart/form-data" novalidate>
                @csrf
                @method('PATCH')
    
                <div class="form-group">
                    <label for="nome">Nome:</label>
                    <input type="text" class="form-control @error('nome') is-invalid @enderror" id="nome" name="nome" placeholder="Nome do produto" value="{{ old('nome', $produtos->nome_formatado)}}" required>
                    <div class="invalid-feedback px-0">
                        Por favor, insira um nome!
                    </div>                                                              
                </div>
                
                <div class="form-group">
                    <label for="preco">Preço:</label>
                    <input type="tel" onkeyup="$(this).mask('##,00', {reverse: true})" maxlength="15" class="form-control @error('preco') is-invalid @enderror" id="preco" name="preco" placeholder="Preço do produto" value="{{ old('preco', $produtos->preco_formatado) }}" required>
                    <div class="invalid-feedback px-0">
                        Por favor, insira um preço!
                    </div>
                </div>
    
                <div class="form-group">
                    <label for="preco">Kg:</label>
                    <input type="tel" onkeyup="$(this).mask('00,00')" class="form-control @error('kg') is-invalid @enderror" id="kg" name="kg" placeholder="Kg do produto" value="{{ old('kg', $produtos->kg) }}" required>
                    <div class="invalid-feedback px-0">
                        Por favor, insira um peso!
                    </div>
                </div>
    
                <div class="form-group">
                    <label for="descricao">Descrição:</label>
                    <textarea name="descricao" id="descricao" class="form-control @error('descricao') is-invalid @enderror" placeholder="Informe algo adicional:" style="resize: none;" required>{{ old('descricao', $produtos->descricao) }}</textarea>
                    <div class="invalid-feedback px-0">
                        Por favor, insira uma descrição!
                    </div>
                </div>
    
       
                <div class="form-group mt-3 ">
                    <label class="col-12" for="imagem">Selecione uma imagem:</label>
                    <input type="file" id="imagem" name="imagem" class="form-control-file col-12">
                    <div class="d-flex align-items-center">
                    @if ($produtos->imagem)
                    <img src="{{ $produtos->base64() }}" alt="" class="img-preview mx-auto">
                    @else
                        <p>Nenhuma imagem selecionada.</p>
                    @endif
                        </div>
                    @error('imagem')
                    <div class="text-danger col-12">{{ $message }}</div>
                    @enderror
                </div>
    
                <div class="d-flex justify-content-center mt-3">
                    <input type="submit" class="btn botao" value="Salvar">
                </div>
    
            </form>
        </div>
    </div>
</div>

@endsection
