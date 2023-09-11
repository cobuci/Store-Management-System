<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    public function orders()
    {
        return $this->hasMany(Order::class, 'order_id', 'order_id');
    }

    protected $fillable = [
        'order_id',
        'cost',
        'discount',
        'price',
        'customer_id',
        'customer_name',
        'payment_method',        
    ];



    use HasFactory;
    public $timestamps = true;

}
