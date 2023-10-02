<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    public $timestamps = true;
    protected $fillable = [
        'order_id',
        'cost',
        'discount',
        'price',
        'customer_id',
        'customer_name',
        'payment_method',
    ];

    public static function totalDue()
    {
        $total = 0;
        $sales = Sale::where('payment_status', 'LIKE', '0')->get();
        foreach ($sales as $sale) {
            $total = $total + $sale->price;
        }
        return $total;
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'order_id', 'order_id');
    }




    use HasFactory;

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

}
