<?php

namespace Thangtn\Scss;

use Illuminate\Support\ServiceProvider;

class ScssServiceProvinder extends ServiceProvider
{

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        'providers' => [
            /*
                 * Application Service Providers...
                 */

                App\Providers\RouteServiceProvider::class,
                lyhuynh\firstpackage\FirstPackageServiceProvider::class,
        ]
    }
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
