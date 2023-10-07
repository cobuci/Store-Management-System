<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{

    public static function show()
    {
        return Category::select('id', 'name')
            ->orderBy('name')
            ->get();
    }

    public function products()
    {
        return $this->hasMany(Product::class)
            ->orderByRaw('amount > 0 DESC')
            ->orderBy('name');
    }

    use HasFactory;
}
