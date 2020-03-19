<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\User;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
         'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('superAdmin', function ($user){
            if ($user->level == User::SUBPER_ADMIN){
                return true;
            }
            return false;
        });

        Gate::define('admin', function ($user){
            if ($user->level == User::ADMIN){
                return true;
            }
            return false;
        });
    }
}
