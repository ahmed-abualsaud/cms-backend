<?php

namespace CMS\Auth\Provider;

use Illuminate\Support\ServiceProvider;

use CMS\Auth\Domain\Service\AuthService;
use CMS\Auth\Contract\AuthServiceContract;

class ContractProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(AuthServiceContract::class, AuthService::class);
    }
}