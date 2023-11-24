<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReceiptList extends Model
{
    use HasFactory;

    protected $fillable = [
        "key",
        "name",
    ];

    public function items()
    {
        return $this->hasMany(ReceiptItem::class);
    }


}
