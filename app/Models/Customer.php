<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{

    protected $fillable = ['name', 'email', 'phone', 'gender', 'zipcode', 'street', 'number', 'district'];

    
    public static function show()
    {
        return Customer::select('id', 'name')
            ->orderBy('name')
            ->get();
    }


    public function sales()
    {
        return $this->hasMany(Sale::class,  'customer_id', 'id');
    }

    public function unconfirmedSale()
    {
        return $this->sales()->where('payment_status', 'LIKE', '0');
    }

    public function confirmedSale()
    {
        return $this->sales()->where('payment_status', 'LIKE', '1');
    }

    public function debit()
    {
        return $this->sales()->where('payment_status', 'LIKE', '0')->sum('price');
    }

    public function spent()
    {
        return $this->sales()->where('payment_status', 'LIKE', '1')->sum('price');
    }


    public function water()
    {
        $getConfig = json_decode(file_get_contents('../config/app_settings.json'));
        $productId = $getConfig->water->value;

        return $this->sales()->whereHas('orders', function ($query) use ($productId) {
            $query->where('product_id', $productId);
        })
            ->with(['orders' => function ($query) use ($productId) {
                $query->where('product_id', $productId);
            }])
            ->get()
            ->pluck('orders')
            ->flatten()
            ->sum('amount');
    }

    use HasFactory;

    public $timestamps = true;
}
