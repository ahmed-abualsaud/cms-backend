<?php

namespace CMS\Attribute\Provider;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Foundation\CachesConfiguration;

class AttributeServiceProvider extends ServiceProvider 
{    
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot() 
    {
        $this->loadMigrationsFrom(__DIR__.'/../Infra/Database/Migration');
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register() 
    {
        if (! ($this->app instanceof CachesConfiguration && $this->app->configurationIsCached())) {
            
            $config = $this->app->make('config');
            $config->set(
                'route-attributes.directories.CMS\\Attribute\\App\\HTTP\\Controller\\', 
                base_path('src/Attribute/App/HTTP/Controller')
            );
        }

        $this->app->register(DTOProvider::class);
        $this->app->register(ContractProvider::class);

        require_once(app_path('Helpers/HTTPHelper.php'));
    }
}
