<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\TransactionsRepositoryInterface;
use App\Repositories\TransactionsRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(TransactionsRepositoryInterface::class, TransactionsRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
