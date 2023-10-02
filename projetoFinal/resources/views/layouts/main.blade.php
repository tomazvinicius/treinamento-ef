<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title')</title>


    {{-- Icon Google --}}
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    {{-- Jquery --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    {{--  CSS da aplicação  --}}
    <link rel="stylesheet" href="/css/app.css">
    <link rel="icon" type="image/x-icon" href="/img/fav.png">

    
</head>
<body>
  {{-- Navbar --}}
  <!DOCTYPE html>
  <html lang="pt-BR">
  <head>
      <!-- ... Cabeçalho do HTML ... -->
  </head>
  <body>
    <!-- Navbar -->
    <header>
      <nav class="navbar navbar-expand-lg ">
        <div class="container">
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbar">
            <ul class="navbar-nav mx-auto">
              <li>
                <a class="nav-link" href="{{ route('produto.read') }}">Produtos</a>
              </li>
            
              <li class="nav-item dropdown">
                <a class="nav-link" href="{{ route('produto.dashboard') }}">Tabela</a>
              </li>

              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="produtosDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Outros
                </a>
                <div class="dropdown-menu custom-link" aria-labelledby="produtosDropdown">
              
                  <a class="dropdown-item " href="{{ route('produto.create') }}">Cadastrar Produto</a>
            </div>
              </li>
            </ul>
          </div>
        </div>
      </nav>
    </header>
  
    <!-- ... Corpo do HTML ... -->
  
  </body>
  </html>
  

  <div class="container mt-4">
    @yield('content')
  </div>

  {{-- Footer --}}
  <footer class="text-center mt-4">
    <p>Leninha Doceria Artesanal &copy; 2023</p> 
  </footer>
  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  
  {{-- Fonte Awesome --}}
  <script src="https://kit.fontawesome.com/8b1a4d86ba.js" crossorigin="anonymous"></script>
</body>
</html>
