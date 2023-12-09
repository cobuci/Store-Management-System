<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'brand',
        'weight',
        'cost',
        'sale',
        'amount',
        'expiration_date',
        'category_id',
        'upc'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class );
    }


    use HasFactory;
    public $timestamps = false;
}
