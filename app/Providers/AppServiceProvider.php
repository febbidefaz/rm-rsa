<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Gate;

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
        Gate::before(function ($user = null, $ability = null) {
            if ($ability === 'admin') {
                return session('user_rm_role') === 'admin';
            }
    
            return null;
        });
    
        View::composer('*', function ($view) {
            $view->with('rmUser', (object)[
                'name' => session('user_rm_nama'),
                'role' => session('user_rm_role'),
            ]);
        });
    }
}
