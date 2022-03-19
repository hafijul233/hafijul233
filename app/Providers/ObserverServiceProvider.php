<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Admin\Models\Rbac\Permission;
use Modules\Admin\Models\Rbac\Role;
use Modules\Admin\Models\User;
use Modules\Admin\Observers\Rbac\PermissionObserver;
use Modules\Admin\Observers\Rbac\RoleObserver;
use Modules\Admin\Observers\Rbac\UserObserver;

class ObserverServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }

    /**
     * Register any observer for your application.
     *
     * @return void
     */
    public function boot()
    {

    }
}
