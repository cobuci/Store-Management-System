<?php

namespace App\Observers;

use Illuminate\Support\Facades\Cache;

class CategoryObserver
{
    public function updated()
    {
        Cache::forget('categories');
    }

    public function created()
    {
        Cache::forget('categories');
    }

    public function deleted()
    {
        Cache::forget('categories');
    }
}
