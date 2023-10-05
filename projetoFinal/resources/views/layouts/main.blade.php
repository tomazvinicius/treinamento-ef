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
    <link rel="icon" type="image/x-icon" href="/logo.svg">

</head>
<body>
     {{-- Navbar --}}
     <header>
      <nav class="navbar navbar-expand-lg">
        <div class="container">
          <div class="mx-auto">
            <a class="navbar-brand" href="{{ route('produto.index') }}"><i class="fa-solid fa-cookie-bite fa-bounce fa-2xl" style="color: #ffffff;"></i>   </a>
          </div>
        </div>
      </nav>
    </header>
  {{-- Mensagem de sucesso --}}
  <div class="container mt-4">
    @if (session('success'))
      <div class="alert alert-success" role="alert">
          {{ session('success') }}
      </div>
    @endif
    @if (session('error'))
      <div class="alert alert-danger" role="alert">
          {{ session('error') }}
      </div>
    @endif

    @yield('content')
  </div>

  {{-- Footer --}}
  <footer class="text-center mt-4">
    <p>Leninha Doceria Artesanal &copy; 2023</p>
  </footer>

</body>

  {{-- Fechar notificação --}}
  <script>
    $(document).ready(function() {
        $(".alert").delay(5000).slideUp(200, function() {
            $(this).alert('close');
        });
    });
    </script>

<script>
  (function () {
  'use strict'
  const forms = document.querySelectorAll('.requires-validation')
  Array.from(forms)
    .forEach(function (form) {
      form.addEventListener('submit', function (event) {
      if (!form.checkValidity()) {
          event.preventDefault()
          event.stopPropagation()
      }
    
        form.classList.add('was-validated')
      }, false)
    })
  })()
  </script>
  {{-- Script Bootstrap --}}
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

  {{-- Script Jquery --}}
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.js" integrity="sha512-0XDfGxFliYJPFrideYOoxdgNIvrwGTLnmK20xZbCAvPfLGQMzHUsaqZK8ZoH+luXGRxTrS46+Aq400nCnAT0/w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

  {{-- Icones Awesome --}}
  <script src="https://kit.fontawesome.com/8b1a4d86ba.js" crossorigin="anonymous"></script>

  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
</html>
