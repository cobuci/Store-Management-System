<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{

    protected $fillable = ['nome', 'email', 'telefone', 'sexo', 'cep', 'rua','numero','bairro'];


    use HasFactory;
    public $timestamps = false;
}
