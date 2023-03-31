<?php

namespace CMS\Attribute\Provider;

use Illuminate\Support\ServiceProvider;
use CMS\Attribute\App\HTTP\DTO\UpdateAttributeDto;
use CMS\Attribute\App\HTTP\DTO\CreateAttributeDto;

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
        $this->app->bind(CreateAttributeDto::class, function () {
            return CreateAttributeDto::fromArray($this->app->make('request')->all());
        });

        $this->app->bind(UpdateAttributeDto::class, function () {
            return UpdateAttributeDto::fromArray($this->app->make('request')->all());
        });
    }
}