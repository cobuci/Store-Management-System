<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    protected $fillable = [
        'name',
        'brand',
        'weight',
        'cost', 
        'sale', 
        'amount',
        'expiration_date', 
        'category_id'
    ];

    use HasFactory;
    public $timestamps = false;
}
