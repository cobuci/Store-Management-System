<?php

namespace App\Observers;

use App\Models\Cashier;
use Illuminate\Support\Facades\Cache;

class CashierObserver
{
    public function updated(Cashier $cashier)
    {
        if ($cashier->isDirty('balance')) {
            Cache::forget('goal');
        }
    }

    


}
