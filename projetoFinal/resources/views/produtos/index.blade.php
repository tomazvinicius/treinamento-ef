@extends('layouts.main')

@section('title', 'Leninha Doceria Artesanal')

@section('content')
<div class="container">
  <div class="row mt-4 mb-2">

    <div class="col-md-6 text-start mb-2">
      <a class="btn botao-relatorio mb-2" id="gerar-pdf"><i class="fa-sharp fa-regular fa-floppy-disk pr-2"></i>  Emitir relatório </a>
      <a class="btn botao-cadastrar mb-2 " href="{{ route('produto.create') }}"><i class="fa-sharp fa-regular fa-plus pr-2"></i>  Cadastrar produto</a>
    </div>

    <div class="col-md-6">
      <div class="d-flex align-items-center p-0 ">
        <input type="text" id="search" class="form-control " placeholder="Pesquisar ">
      </div>
    </div>
  </div>
  
  <div class="table-responsive">
    <table class="table">
      <thead class="table-head">
        <tr>
          <th scope="col">Nome do produto</th>
          <th scope="col">Preço</th>
          <th scope="col">KG</th>
          <th scope="col">Descrição</th>
          <th scope="col">Ações</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($produtos as $produto)
        <tr data-produto-id="{{$produto->id}}">
          <td>{{ $produto->nome_formatado }}</td>
          <td>R$ {{$produto->preco}}</td>
          <td> {{$produto->kg}} kg</td>
          <td>{{$produto->descricao}}</td>
          <td>
            <div class="btn-group  action-buttons" role="group">
              {{-- Botão de editar --}}
              <a href="/produtos/editar/{{$produto->id}}" class="btn btn-action-edit "><i class="fa-solid fa-pencil fa-lg "></i></a>
              <a href="#"></a>
              <!-- Botão de exclusão -->
              <button class="btn btn-action-delete" data-bs-toggle="modal" data-bs-target="#deleteModal{{$produto->id}}">
                <i class="fa-solid fa-trash"></i>
              </button>
              <!-- Modal de confirmação de exclusão -->
              <div class="modal fade" id="deleteModal{{$produto->id}}" tabindex="-1" aria-labelledby="deleteModalLabel{{$produto->id}}" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="deleteModalLabel{{$produto->id}}">Confirmação de Exclusão</h5>
                      <button  class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                    </div>
                    <div class="modal-body">
                      <p>Você tem certeza de que deseja excluir este produto?</p>
                    </div>
                    <div class="modal-footer">
                      <form action="/produtos/delete/{{$produto->id}}" method="POST" >
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-delete">Confirmar Exclusão</button>
                      </form>
                      <button class="btn btn-cancelar" data-bs-dismiss="modal">Cancelar</button>
                    </div>
                  </div>
                </div>
              </div>
              
            </div>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
</div>

<script>
  // Função para filtrar a tabela com base no campo de pesquisa
  $('#search').on('keyup', function() {
    var searchText = $(this).val().toUpperCase();

    if (searchText.length > 3) {
      $('table tbody tr').each(function() {
        var textoTabela = $(this).find('td:first').text().toUpperCase().trim();

        if (textoTabela.indexOf(searchText) === -1) {
          $(this).hide();
        } else {
          $(this).show();
        }
      });
    } else {
      $('table tbody tr').show();
    }
  });

  $('#gerar-pdf').click(function(){
    let produtosIds = $('table tbody tr:not(:hidden)').map(function(){
      return $(this).data('produto-id')
    })
  
    url = '{{route('produto.pdf')}}/?ids[]=' + produtosIds.toArray().join('&ids[]=')
    window.open(url);
  })
</script>
@endsection