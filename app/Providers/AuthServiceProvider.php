<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //管理者 role:1
        Gate::define('admin', function ($user){
            return ($user->role == 1);
        });
        
        //部長　role:2
        Gate::define('dept_manager', function ($user) {
            return ($user->role > 0 && $user->role <= 2);
        });
        
        //確認者以上に許可　次長・マネージャー・リーダーなどを想定）　
        Gate::define('reviewer_higher', function ($user) {
            return ($user->role > 0 && $user->role <= 5);
        });
        
        // 一般ユーザ以上（つまり全権限）に許可
        Gate::define('user_higher', function ($user) {
            return ($user->role > 0 && $user->role <= 10);
        });
        
    }    
}
