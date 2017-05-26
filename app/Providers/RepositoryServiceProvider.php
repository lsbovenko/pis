<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerRepositories();
    }

    /**
     * Register the application bindings.
     *
     * @return void
     */
    private function registerRepositories()
    {
        foreach ($this->getRepositoriesList() as $name => $className) {
            $this->app->bind('repository' . $name, function ($app) use ($className) {
                return new $className($app);
            });
        }


        $this->app->alias('entrust', 'Zizaco\Entrust\Entrust');
    }

    private function getRepositoriesList() : array
    {
        return [
            'role' => App\Repositories\Role::class,
            'department' => App\Repositories\Department::class,
        ];
    }
}
