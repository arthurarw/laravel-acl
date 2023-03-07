<?php

namespace App\Providers;

use App\Models\Resource;
use App\Models\Thread;
use App\Models\User;
use App\Policies\ThreadPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Schema;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Thread::class => ThreadPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Gate::before(function (User $user) {
            return $user->isAdmin();
        });

        if (Schema::hasTable('resources')) {
            $resources = Resource::with('roles')->get();

            if ($resources->isNotEmpty()) {
                foreach ($resources as $resource) {
                    Gate::define($resource->resource, function ($user) use ($resource) {
                        return $resource->roles->contains($user->role);
                    });
                }
            }
        }
    }
}
