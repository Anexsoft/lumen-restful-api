<?php

namespace App\Providers;

use App\Repositories\ExampleRepository;
use Illuminate\Support\ServiceProvider;
use App\Repositories\Interfaces\IExampleRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(IExampleRepository::class, ExampleRepository::class);
    }
}
