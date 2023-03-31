<?php

namespace CMS\Attribute\Provider;

use Illuminate\Support\ServiceProvider;
use CMS\Attribute\Domain\Service\AttributeService;
use CMS\Attribute\Contract\AttributeServiceContract;

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
        $this->app->bind(AttributeServiceContract::class, AttributeService::class);
    }
}