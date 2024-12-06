<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Form;
use App\Models\FormField;
use App\Models\User;
use App\Policies\FormFieldPolicy;
use App\Policies\FormPolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        User::class => UserPolicy::class,
        Form::class => FormPolicy::class,
        FormField::class => FormFieldPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        Gate::define('create-data', function (User $user, Form $form) {
            return $user->isSuperAdmin() || $user->hasPermissionTo("create-$form->slug");
        });
        Gate::define('read-data', function (User $user, Form $form) {
            return $user->isSuperAdmin() || $user->hasPermissionTo("read-$form->slug");
        });

        Gate::define('update-data', function (User $user, Form $form) {
            return $user->isSuperAdmin() || $user->hasPermissionTo("update-$form->slug");
        });

        Gate::define('delete-data', function (User $user, Form $form) {
            return $user->isSuperAdmin() || $user->hasPermissionTo("delete-$form->slug");
        });

    }
}
