<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    use HasFactory;

    protected $table = 'produtos';

    protected $guarded = [];
    public $timestamps = false;

    public function getPrecoFormatadoAttribute()
    {
        return number_format($this->preco, 2, ',', '.');
    }

    public function getNomeFormatadoAttribute()
    {
        return mb_strtolower($this->nome);
    }

    public function base64()
    {
        $caminhoImagem = public_path("storage/{$this->imagem}");
        $extension = pathinfo($caminhoImagem, PATHINFO_EXTENSION);
        $dataImage = "data:image/{$extension};base64,";

        return $dataImage . base64_encode(file_get_contents($caminhoImagem));
    }
}