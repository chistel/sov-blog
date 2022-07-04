<?php
/*
 * Copyright (C) 2022,  Chistel Brown,  - All Rights Reserved
 * @project                  courier
 * @file                           CoreProvider.php
 * @author                  Chistel Brown
 * @site                          <http://twitter.com/chistelbrown>
 * @email                      chistelbrown@gmail.com
 * @lastmodified     03/02/2022, 10:34 AM
 */

namespace App\Providers;

use App\Contracts\Repositories\Articles\ArticleRepository;
use App\Contracts\Repositories\Users\UserRepository;
use App\Models\Users\User;
use App\Repositories\Articles\EloquentArticleRepository;
use App\Repositories\Users\EloquentUserRepository;
use App\Services\Authentication\LoginRateLimiter;
use App\Traits\Common\Providable;
use Illuminate\Cache\RateLimiter;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;

class CoreProvider extends ServiceProvider
{
    use Providable;

    /**
     * Aliases to be defined and set by the service provider.
     *
     * @var array
     */
    protected array $aliases = [];

    /**
     * Return an array of files to be loaded once booted.
     *
     * @var array
     */
    protected array $files = [];

    /**
     * Register the repositories you wish to register with Shift.
     *
     * @var array
     */
    protected array $repositories = [
        ArticleRepository::class => EloquentArticleRepository::class,
        UserRepository::class => EloquentUserRepository::class,
    ];

    /**
     * Register the required route middleware.
     *
     * @var array
     */
    protected array $routeMiddleware = [];

    /**
     * Base register method. Simply registers the aliases and service providers defined
     * by the service provider child class.
     */
    public function register()
    {
        $this->registerRepositories();
        $this->registerAliases();
        $this->registerMiddleware();
        $this->registerLoginLimiter();
    }

    /**
     * Boot iles that are required.
     */
    public function boot()
    {
        $this->bootFiles();

        Relation::morphMap([
            'user' => User::class,
        ]);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array_keys($this->repositories);
    }

    /**
     * Registers the defined repository interfaces and binds them to an implementation.
     *
     * @return void
     */
    protected function registerRepositories(): void
    {
        foreach ($this->repositories as $interface => $repository) {
            $this->app->singleton($interface, $repository);
        }
    }

    /**
     * Registers the specified middleware for the service proivder.
     */
    protected function registerMiddleware(): void
    {
        foreach ($this->routeMiddleware as $key => $middleware) {
            $this->app['router']->aliasMiddleware($key, $middleware);
        }
    }

    private function registerLoginLimiter(): void
    {
        $this->app->singleton(LoginRateLimiter::class, function ($app) {
            return new LoginRateLimiter(
                app(RateLimiter::class),
                $app['config']->get('auth.temporary_lock.max_attempts'),
                $app['config']->get('auth.temporary_lock.duration') * 60 // Rate limiter uses seconds
            );
        });
    }
}
