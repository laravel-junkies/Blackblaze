<?php

namespace LaraJunkies\Backblaze\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class Backblaze
 * @package LaraJunkies\Backblaze\Facades
 * @author Tobias Maxham
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