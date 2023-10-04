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
        return strtolower($this->nome);
    }
}