<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{

    public function products()
    {
        return $this->hasMany(Product::class)->orderBy('name');
    }

    public static function show()
    {
        return Category::select('id', 'name')
            ->orderBy('name')
            ->get();
    }

    use HasFactory;
}
