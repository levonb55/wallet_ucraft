<?php

namespace App\Providers;

use App\Contracts\Repositories\CardRepository as CardRepositoryInterface;
use App\Repositories\CardRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(CardRepositoryInterface::class, CardRepository::class);
    }
}
