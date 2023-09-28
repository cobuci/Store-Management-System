<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    public function sale()
    {
        return $this->belongsTo(Sale::class, 'order_id', 'order_id');
    }
    protected $fillable = [
        'id',
        'order_id',
        'product_id',
        'product_name',
        'product_brand',
        'unit_cost',
        'unit_price',
        'weight',
        'amount',
        'payment_status'
    ];

    public $timestamps = false;
    use HasFactory;
}
