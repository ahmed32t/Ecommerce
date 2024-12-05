<?php

namespace App\Providers;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {  if(!app()->runningInConsole()){

        /*share variable to view */

        /*
        $productfirst=Product::firstor(function(){
            Product::create([
                'name'=>'product',
                'user_id'=>1
            ]);
        });
        view()->share('fproduct',$productfirst);*/

    }

}
}

