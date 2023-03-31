<?php

namespace CMS\Auth\Provider;

use CMS\Auth\App\HTTP\DTO\SigninDto;
use CMS\Auth\App\HTTP\DTO\SignupDto;
use CMS\Auth\App\HTTP\DTO\UpdateUserDto;

use Illuminate\Support\ServiceProvider;

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
        $this->app->bind(SigninDto::class, function () {
            return SigninDto::fromArray($this->app->make('request')->all());
         });

        $this->app->bind(SignupDto::class, function () {
            return SignupDto::fromArray($this->app->make('request')->all());
        });

        $this->app->bind(UpdateUserDto::class, function () {
            return UpdateUserDto::fromArray($this->app->make('request')->all());
        });
    }
}