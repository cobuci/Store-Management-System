<?php

namespace App\Providers;

use App\Models\Cashier;
use App\Models\Category;
use App\Models\Product;
use App\Observers\CashierObserver;
use App\Observers\CategoryObserver;
use App\Observers\ProductObserver;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        Paginator::useTailwind();
        Cashier::observe(CashierObserver::class);
        Category::observe(CategoryObserver::class);

    }
}
