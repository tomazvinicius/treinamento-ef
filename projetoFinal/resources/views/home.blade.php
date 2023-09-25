@extends('layouts.main')

@section('title', 'Leninha Doceria Artesanal')


@section('content')


<header>
    <nav class="navbar navbar-expand-lg navbar-light">
      <div class="collapse navbar-collapse" id="navbar">
        <a href="/" class="navbar-brand"></a>
        <ul class="navbar-nav">
          <li class="nav-item">
            <a href="/" class="nav-link">Produtos</a>
          </li>
          <li class="nav-item">
            <a href="/produtos/cadastro" class="nav-link">Cadastrar Produtos</a>
          </li>
        </ul>
      </div>
    </nav>
  </header>


@endsection

