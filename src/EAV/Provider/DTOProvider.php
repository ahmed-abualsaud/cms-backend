<?php

namespace CMS\EAV\Provider;

use Illuminate\Support\ServiceProvider;
use CMS\EAV\App\HTTP\DTO\AssignAttributesDto;

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
        $this->app->bind(AssignAttributesDto::class, function () {
            return AssignAttributesDto::fromArray($this->app->make('request')->all());
        });


    }
}