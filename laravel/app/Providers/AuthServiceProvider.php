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

        // 系統管理者 Gate 規則
        Gate::define('admin', function ($user) {
            return $user->role === User::ROLE_ADMIN;
        });

        // 行銷人員 Gate 規則
        Gate::define('marketer', function ($user) {
            return $user->role === User::ROLE_MARKETER;
        });

        // 財務人員 Gate 規則
        Gate::define('accountant', function ($user) {
            return $user->role === User::ROLE_ACCOUNTANT;
        });

        // 臨時人員 Gate 規則
        Gate::define('staff', function ($user) {
            return $user->role === User::ROLE_STAFF;
        });

        // 講師 Gate 規則
        Gate::define('teacher', function ($user) {
            return $user->role === User::ROLE_TEACHER;
        });

        // 業務人員 Gate 規則
        Gate::define('saleser', function ($user) {
            return $user->role === User::ROLE_SALSER;
        });

        // 業務主管 Gate 規則
        Gate::define('msaleser', function ($user) {
            return $user->role === User::ROLE_MSALSER;
        });

        // 行政人員 Gate 規則
        Gate::define('officestaff', function ($user) {
            return $user->role === User::ROLE_OFFICESTAFF;
        });
    }
}
