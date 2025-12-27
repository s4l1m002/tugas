<?php

namespace App\Providers;

// Tambahkan use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AppServiceProvider extends ServiceProvider
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
        $this->registerPolicies();

        // 1. Definisikan Gate untuk Admin
        Gate::define('isAdmin', function ($user) {
            return $user->role === 'admin';
        });

        // 2. Definisikan Gate untuk Marketing
        Gate::define('isMarketing', function ($user) {
            return $user->role === 'marketing';
        });
        
        // 3. Definisikan Gate untuk User (Optional)
        Gate::define('isUser', function ($user) {
            return $user->role === 'user';
        });
    }
}