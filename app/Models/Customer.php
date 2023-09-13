<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{

    protected $fillable = ['name', 'email', 'phone', 'gender', 'zipcode', 'street','number','district'];


    use HasFactory;
    public $timestamps = true;
}
