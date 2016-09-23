<?php

namespace Sinclair\Commentable;

use Sinclair\Commentable\Models\Comment;
use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;

class CommentableServiceProvider extends ServiceProvider
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
        AliasLoader::getInstance([
            'Comment' => Comment::class
        ]);

        $this->publishes([
            __DIR__ . '/../../migrations' => database_path('migrations'),
        ], 'migrations');

        $this->publishes([

            __DIR__ . '/../../config/' => config_path()
        ], 'config');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('Sinclair\Commentable\Contracts\Comment', 'Sinclair\Commentable\Models\Comment');

        $this->app->bind('Comment', 'Sinclair\Commentable\Contracts\Comment');
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

}
