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

namespace LaraJunkies\Backblaze\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class Backblaze
 * @package LaraJunkies\Backblaze\Facades
 *
 * @author Tobias Maxham <git2016@maxham.de>
 */
class Backblaze extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'lj.backblaze';
    }
}