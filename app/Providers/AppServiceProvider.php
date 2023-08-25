<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Auth\AuthRepository;
use App\Repositories\Auth\AuthRepositoryInterface;
use App\Repositories\Recipe\RecipeRepository;
use App\Repositories\Recipe\RecipeRepositoryInterface;
use App\Repositories\Ingredient\IngredientRepository;
use App\Repositories\Ingredient\IngredientRepositoryInterface;
use App\Repositories\Order\OrderRepository;
use App\Repositories\Order\OrderRepositoryInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            AuthRepositoryInterface::class, 
            AuthRepository::class
        );
        $this->app->bind(
            RecipeRepositoryInterface::class, 
            RecipeRepository::class
        );
        $this->app->bind(
            IngredientRepositoryInterface::class, 
            IngredientRepository::class
        );
        $this->app->bind(
            OrderRepositoryInterface::class, 
            OrderRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
