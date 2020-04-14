<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport; 
use App\Gates\RoleGates;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
        // 'App\Post' => 'App\Policies\PostPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        Passport::routes();
        // Gate::define('isAllowed',function ($user, $allowed){
        //     // $allowed = explode(':',$allowed);

        //     $roles = $user->roles->pluck('name')->toArray();
        //     return array_intersect($allowed->all(),$roles);
        // });

        Gate::define('isAllowed', 'App\Gates\RoleGate@allowed');
        // Gate::define('allow-edit','App\Gates\PostGates@allowedAction');
    }
}
