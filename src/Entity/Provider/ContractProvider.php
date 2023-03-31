<?php

namespace CMS\Entity\Provider;

use Illuminate\Support\ServiceProvider;
use CMS\Entity\Domain\Service\EntityService;
use CMS\Entity\Contract\EntityServiceContract;

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
        $this->app->bind(EntityServiceContract::class, EntityService::class);
    }
}