<?php

namespace Pipes\Stream\Facades;

use Illuminate\Support\Facades\Facade;

class Stream extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'Pipes\\Stream\\Stream';
    }
}
