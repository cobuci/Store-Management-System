<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    public $timestamps = true;
    protected $fillable = [
        'product_id',
        'product_name',
        'product_brand',
        'product_weight',
        'unit_cost',
        'amount',
        'payment_status',
        'expiration_date',
    ];

}
