<?php

namespace CMS\Auth\Provider;

use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Contracts\Foundation\CachesConfiguration;

use Spatie\Permission\PermissionServiceProvider;
use Spatie\Permission\Exceptions\UnauthorizedException;

use Tymon\JWTAuth\Providers\LaravelServiceProvider;


class AuthServiceProvider extends ServiceProvider 
{    
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/../Infra/Database/Migration');

        $appRouter = $this->app['router'];

        $appRouter->aliasMiddleware('role', \Spatie\Permission\Middlewares\RoleMiddleware::class);
        $appRouter->aliasMiddleware('permission', \Spatie\Permission\Middlewares\PermissionMiddleware::class);
        $appRouter->aliasMiddleware('role_or_permission', \Spatie\Permission\Middlewares\RoleOrPermissionMiddleware::class);

        $appExceptionHandeler = $this->app[ExceptionHandler::class];
        if (method_exists($appExceptionHandeler, 'renderable')) {

            $appExceptionHandeler->renderable(function (UnauthorizedException $e) {
                return failureJSONResponse($e->getMessage(), $e->getStatusCode());
            });

            $appExceptionHandeler->renderable(function (AuthenticationException $e) {
                return failureJSONResponse("User is not logged in.", 403);
            });
        }

    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register() 
    {
        $this->mergeConfigFrom(__DIR__.'/../Infra/Config/JWT.php', 'jwt');
        $this->mergeConfigFrom(__DIR__.'/../Infra/Config/Permission.php', 'permission');

        if (! ($this->app instanceof CachesConfiguration && $this->app->configurationIsCached())) {
            
            $config = $this->app->make('config');
            $config->set(
                'route-attributes.directories.CMS\\Auth\\App\\HTTP\\Controller\\', 
                base_path('src/Auth/App/HTTP/Controller')
            );

            $config->set('auth', require __DIR__.'/../Infra/Config/Auth.php');
        }

        $this->app->register(DTOProvider::class);
        $this->app->register(ContractProvider::class);
        $this->app->register(LaravelServiceProvider::class);
        $this->app->register(PermissionServiceProvider::class);

        require_once(app_path('Helpers/HTTPHelper.php'));
    }
}
