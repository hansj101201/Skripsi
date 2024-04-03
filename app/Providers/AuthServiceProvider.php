<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
        Gate::define("Admin", function ($user) {
            return Auth::user()->rolenya == "Admin";
        });

        Gate::define("Gudang", function ($user) {
            return Auth::user()->rolenya == "Gudang";
        });

        Gate::define("Penjualan", function ($user) {
            return Auth::user()->rolenya == "Penjualan";
        });

        Gate::define("SuperAdmin", function ($user) {
            return Auth::user()->rolenya == "SuperAdmin";
        });

        // Sanctum::usePersonalAccessTokenModel(PersonalAccessToken::class);
    }
}
