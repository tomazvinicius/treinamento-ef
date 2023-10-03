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
   <header>
    <nav class="navbar navbar-expand-lg">
      <div class="container">
        <!-- Link de início centralizado -->
        <div class="mx-auto">
          <a class="navbar-brand" href="{{ route('produto.dashboard') }}"><i class="fa-solid fa-house" style="color: #ffffff;"></i>  Início </a>
        </div>
        <!-- Links adicionais visíveis apenas em telas maiores -->
        <div class="collapse navbar-collapse d-lg-block" id="navbar">
          <ul class="navbar-nav mx-auto">
            <!-- Adicione aqui os links adicionais se necessário -->
          </ul>
        </div>
      </div>
    </nav>
  </header>
  
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
