<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Finance extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'product_amount',
        'value',
        'description',
        'type',
        'date',
    ];

    public $timestamps = false;
}
