<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    public $timestamps = true;
    protected $fillable = [
        'product_id',
        'product_name',
        'unit_cost',
        'amount',
        'payment_status',
    ];

}
