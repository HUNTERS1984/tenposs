<?php

namespace App\Providers;


use App\Repositories\Contracts\TopsRepositoryInterface;
use App\Repositories\Eloquents\TopsRepository;
use Illuminate\Support\ServiceProvider;


use App\Repositories\Contracts\UsersRepositoryInterface;
use App\Repositories\Eloquents\UsersRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->bindRepositories();
    }

    /**
     * Bind all repository interfaces to their
     * concrete implementations.
     */
    protected function bindRepositories()
    {
        $this->app->singleton(UsersRepositoryInterface::class, UsersRepository::class);
        $this->app->singleton(TopsRepositoryInterface::class, TopsRepository::class);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            UsersRepositoryInterface::class,
            TopsRepositoryInterface::class,
        ];
    }
}
