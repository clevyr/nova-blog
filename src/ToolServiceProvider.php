<?php

namespace Clevyr\NovaBlog;

use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Events\ServingNova;
use Laravel\Nova\Nova;
use Clevyr\NovaBlog\NovaBlog as NovaBlogInstance;

class ToolServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Load migrations
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        // Load Routes
        $this->loadRoutesFrom(__DIR__ . '/routes.php');

        // Load CSS file
        Nova::serving(function (ServingNova $event) {
            Nova::style('blog-field', __DIR__.'/../resources/css/styles.css');
        });

        // Register Page Builder resource
        Nova::resources([
            config('nova-blog.nova_resource', \Clevyr\NovaBlog\Nova\BlogPost::class),
        ]);

        // Publish package & vendor files
        if ($this->app->runningInConsole()) {
            // Publish configs.
            $this->publishes([
                __DIR__ . '/../config/nova-blog.php' => config_path('nova-blog.php')
            ], 'clevyr-nova-blog');
            $this->publishes([
                __DIR__ . '/../config/tags.php' => config_path('tags.php')
            ], 'clevyr-nova-blog');

            // Publishing the views.
            $this->publishes([
                __DIR__ . '/../resources/views' => resource_path('views/vendor/nova-blog'),
            ], 'clevyr-nova-blog');
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('NovaBlog', function ($app) {
            return new NovaBlogInstance();
        });
    }
}
