<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{


    public static function show()
    {
        $cat = new Category;
        return $cat->all();
    }
}