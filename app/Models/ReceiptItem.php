<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReceiptItem extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "cod",
        "amount",
        "active",
        "price",
        "total",
        "receipt_list_id",
    ];

    public function list()
    {
        return $this->belongsTo(ReceiptList::class);
    }

}
