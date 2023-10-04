<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cardápio Leninha Doceria Artesanal</title>
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
            <h2>{{ $produto->nome_formatado }}</h2>
            <p>{{ $produto->descricao }}</p>
            <p><strong class="kg-label">KG:</strong> {{ $produto->kg }} kg</p>
            <p><strong class="preco-label">Preço:</strong> R$ {{ $produto->preco }}</p>
        </div>
    @endforeach
</body>
</html>