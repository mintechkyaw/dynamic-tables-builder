<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Form;
use App\Models\FormField;
use App\Policies\FormFieldPolicy;
use App\Policies\FormPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Form::class => FormPolicy::class,
        FormField::class => FormFieldPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
    }
}
