<?php

namespace App\Providers;
use Illuminate\Support\ServiceProvider;

use App\Repositories\Contracts\ItemsRepositoryInterface;
use App\Repositories\Contracts\NewsRepositoryInterface;
use App\Repositories\Contracts\PhotosRepositoryInterface;
use App\Repositories\Contracts\ReservesRepositoryInterface;
use App\Repositories\Contracts\Top1sRepositoryInterface;
use App\Repositories\Contracts\TopsRepositoryInterface;
use App\Repositories\Eloquents\ItemsRepository;
use App\Repositories\Eloquents\NewsRepository;
use App\Repositories\Eloquents\PhotosRepository;
use App\Repositories\Eloquents\ReservesRepository;
use App\Repositories\Eloquents\Top1sRepository;
use App\Repositories\Eloquents\TopsRepository;


use App\Repositories\Contracts\UsersRepositoryInterface;
use App\Repositories\Contracts\AppsRepositoryInterface;
use App\Repositories\Eloquents\UsersRepository;
use App\Repositories\Eloquents\AppsRepository;
use App\Repositories\Contracts\ChatLineRepositoryInterface;
use App\Repositories\Eloquents\ChatLineRepository;

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
        $this->app->singleton(AppsRepositoryInterface::class, AppsRepository::class);
        $this->app->singleton(ChatLineRepositoryInterface::class, ChatLineRepository::class);
        $this->app->singleton(TopsRepositoryInterface::class, TopsRepository::class);
        $this->app->singleton(PhotosRepositoryInterface::class, PhotosRepository::class);
        $this->app->singleton(ItemsRepositoryInterface::class, ItemsRepository::class);
        $this->app->singleton(NewsRepositoryInterface::class, NewsRepository::class);
        $this->app->singleton(ReservesRepositoryInterface::class, ReservesRepository::class);
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
            AppsRepositoryInterface::class,
            ChatLineRepositoryInterface::class,
            TopsRepositoryInterface::class,
            PhotosRepositoryInterface::class,
            ItemsRepositoryInterface::class,
            NewsRepositoryInterface::class,
            ReservesRepositoryInterface::class,
        ];
    }
}
