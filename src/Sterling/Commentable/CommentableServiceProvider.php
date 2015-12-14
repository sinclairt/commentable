<?php namespace Sterling\Commentable;

use App\Facades\Comment;
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
            __DIR__ . '/Models/'           => app_path('Models'),
            __DIR__ . '/Contracts/'        => app_path('Contracts'),
            __DIR__ . '/../../migrations/' => database_path('migrations')
        ]);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Contracts\Comment', 'App\Models\Comment');

        $this->app->bind('Comment', 'App\Contracts\Comment');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [ ];
    }

}
