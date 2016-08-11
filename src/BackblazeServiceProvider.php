<?php

/*
 * This file is part of Laravel Junkies Backblaze.
 *
 * Copyright (c) 2016 Tobias Maxham <git2016@maxham.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Feel free to edit as you please, and have fun.
 */

namespace LaraJunkies\Backblaze;

use Illuminate\Contracts\Container\Container;
use Illuminate\Support\ServiceProvider;

/**
 * Class BackblazeServiceProvider
 * @package LaraJunkies\Backblaze
 *
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
            $config = config('lj-backblaze');
            return new BackblazeManager(new \b2_api(), $config);
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
