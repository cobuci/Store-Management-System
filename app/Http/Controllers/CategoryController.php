<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Support\Facades\Cache;

class CategoryController extends Controller
{

    public static function show()
    {
        return Cache::rememberForever('categories', fn () => Category::all());
    }
}
