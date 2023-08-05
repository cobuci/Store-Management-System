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

    use HasFactory;
    public $timestamps = false;

}
