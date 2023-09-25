@extends('layout.main')
@section('title', 'Leninha Doceria Artesanal')

@section('content')
@foreach ($products as $product)
    <p>{{$product->nome}} -- {{$product->descricao}}</p>
@endforeach    


@endsection