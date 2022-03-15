<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categoria;

class CategoriaController extends Controller
{

    
    public static function listar()
    {
        $cat = new Categoria;
        $categoria = $cat->all();

        return $categoria;
    }
}
