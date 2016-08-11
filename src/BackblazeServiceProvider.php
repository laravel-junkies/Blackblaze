<?php

namespace LaraJunkies\Backblaze;

use Illuminate\Contracts\Container\Container;
use Illuminate\Support\ServiceProvider;

/**
 * @author Tobias Maxham <git2016@maxham.de>
 */
class BackblazeServiceProvider extends ServiceProvider
{

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        $this->registerBackblaze($this->app);
    }

    private function registerBackblaze($app)
    {
        $this->app->singleton('lj.backblaze', function (Container $app) {
            return new BackblazeManager(new \b2_api());
        });
        $this->app->alias('lj.backblaze', BackblazeManager::class);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return string[]
     */
    public function provides()
    {
        return [
            'lj.backblaze',
        ];
    }

}
