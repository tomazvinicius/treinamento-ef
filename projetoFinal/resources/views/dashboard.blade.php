@extends('layouts.main')

@section('title', 'Leninha Doceria Artesanal')

@section('content')
<div class="container">
  <div class="table-responsive">
    <table class="table">
      <thead class="table-head">
        <tr>
          <th scope="col">Nome do produto</th>
          <th scope="col">Preço</th>
          <th scope="col">Descrição</th>
          <th scope="col">Ações</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($produtos as $produto)
        <tr>
          <td>{{$produto->nome}}</td>
          <td>{{$produto->preco}}</td>
          <td>{{$produto->descricao}}</td>
          <td>
            <div class="btn-group  action-buttons" role="group">
              {{-- Botão de editar --}}
              <a href="/produtos/editar/{{$produto->id}}" class="btn btn-action-edit "><i class="material-icons">edit</i></a>
              <a href="#"></a>
              <form action="/produtos/delete/{{$produto->id}}" method="POST">
                @csrf
                @method('DELETE')

                <!-- Botão de exclusão -->
                <button type="button" class="btn btn-action-delete" data-bs-toggle="modal" data-bs-target="#deleteModal{{$produto->id}}">
                  <i class="material-icons">delete</i>
                </button>

                <!-- Modal de confirmação de exclusão -->
                <div class="modal fade" id="deleteModal{{$produto->id}}" tabindex="-1" aria-labelledby="deleteModalLabel{{$produto->id}}" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel{{$produto->id}}">Confirmação de Exclusão</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                      </div>
                      <div class="modal-body">
                        <p>Você tem certeza de que deseja excluir este produto?</p>
                      </div>
                      <div class="modal-footer">
                        <form action="/produtos/delete/{{$produto->id}}" method="POST">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="btn btn-delete">Confirmar Exclusão</button>
                        </form>
                        <button type="button" class="btn btn-nao-deletar" data-bs-dismiss="modal">Cancelar</button>
                      </div>
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
<script>
  $('.btn-danger').on('click', function() {
    let id = $(this).data('produto');
    $('#deleteModal form').attr('action', '/produtos/delete/' + id);
  });
</script>
@endsection
