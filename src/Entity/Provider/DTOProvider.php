<?php

namespace CMS\Entity\Provider;

use Illuminate\Support\ServiceProvider;
use CMS\Entity\App\HTTP\DTO\UpdateEntityDto;
use CMS\Entity\App\HTTP\DTO\CreateEntityDto;

class DTOProvider extends ServiceProvider
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
        $this->app->bind(CreateEntityDto::class, function () {
            return CreateEntityDto::fromArray($this->app->make('request')->all());
        });

        $this->app->bind(UpdateEntityDto::class, function () {
            return UpdateEntityDto::fromArray($this->app->make('request')->all());
        });
    }
}