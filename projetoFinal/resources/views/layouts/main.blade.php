<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title')</title>

    <!-- Fonte do Google -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto" rel="stylesheet">

    {{-- Icon Google --}}
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    {{-- Jquery --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>


    <!-- CSS da aplicação -->
    <link rel="stylesheet" href="/css/app.css">

    <link rel="icon" type="image/x-icon" href="/img/fav.png">
    
</head>

<header>
  <nav class="navbar navbar-expand-lg navbar-light">
          <a href="/" class="navbar-brand"></a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbar">
              <ul class="navbar-nav">
                  <li class="nav-item">
                      <a href="/" class="nav-link">Home</a>
                  </li>
                  <li class="nav-item">
                      <a href="/produtos/ler" class="nav-link">Produtos</a>
                  </li>
                  <li class="nav-item">
                      <a href="/produtos/cadastrar" class="nav-link">Cadastrar</a>
                  </li>
                  <li class="nav-item">
                      <a href="/produtos/tabela" class="nav-link">Tabela</a>
                  </li>
              </ul>
          </div>
  </nav>
</header>

  
@yield('content')

  <footer>
    <p>Leninha Doceria Artesanal &copy; 2023</p> 
  </footer>

  </body>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</html>