<?php


use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Policies\TaskPolicy;

class TodoServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
         Task::class => TaskPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
