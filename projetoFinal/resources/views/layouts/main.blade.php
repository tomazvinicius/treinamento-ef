<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title')</title>

    {{-- Fonte da Google --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto" rel="stylesheet">

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
{{-- Navbar --}}
<header>
  <nav class="navbar navbar-expand-lg navbar-light ">
    <div class="container text-center">
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbar">
        <ul class="navbar-nav mx-auto">
          <li class="nav-item">
            <a href="/" class="nav-link">Home</a> 
          </li>
          <li class="nav-item">
            <a href="{{ route('produto.read') }}" class="nav-link">Produtos</a>
          </li>
          <li class="nav-item">
            <a href="{{ route('produto.create') }}" class="nav-link">Cadastrar</a>
          </li>
          <li class="nav-item">
            <a href="{{ route('produto.dashboard') }}" class="nav-link">Dashboard</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</header>
@yield('content')

{{-- Footer --}}
  <footer>
    <p>Leninha Doceria Artesanal &copy; 2023</p> 
  </footer>
  
  </body>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</html>