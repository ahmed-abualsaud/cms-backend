<?php

namespace CMS\EAV\Provider;

use Illuminate\Support\ServiceProvider;

use CMS\EAV\Domain\Service\EAVService;
use CMS\EAV\Contract\EAVServiceContract;
use CMS\EAV\Domain\Service\EntityAttributeService;
use CMS\EAV\Contract\EntityAttributeServiceContract;

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
        $this->app->bind(EAVServiceContract::class, EAVService::class);
        $this->app->bind(EntityAttributeServiceContract::class, EntityAttributeService::class);
    }
}