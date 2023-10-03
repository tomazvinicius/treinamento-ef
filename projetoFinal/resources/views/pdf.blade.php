<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cardápio do Restaurante Leninha</title>
       {{--  CSS do PDF  --}}
       <link rel="stylesheet" href="css/pdf.css">
       <link rel="icon" type="image/x-icon" href="logo.svg">
</head>
<body>
    <div class="header">
        <h1>Cardápio - Leninha Doceria Artesanal</h1>
    </div>

    @foreach ($produtos as $produto)
        <div class="menu-item">
            <img src="{{ $produto->imagem }}" alt="{{ $produto->nome }}" class="produto-imagem">
            <h2>{{ $produto->nome }}</h2>
            <p>{{ $produto->descricao }}</p>
            <p><strong>Preço:</strong> <span>R$ {{ $produto->preco }}</span></p>
        </div>
    @endforeach
</body>
</html>
