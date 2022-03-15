<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    protected $fillable = ['nome','marca','peso','custo','venda','quantidade','validade','id_categoria'];

    use HasFactory;
    public $timestamps = false;
}
