<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;
use App\Models\Admin;
use App\Models\Professional;
use App\Models\User;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Configure morph map for polymorphic relationships
        Relation::morphMap([
            'admin' => Admin::class,
            'professional' => Professional::class,
            'user' => User::class,
        ]);
    }
}
