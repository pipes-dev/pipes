<?php

namespace Pipes\Support\Traits;

use Pipes\Stream\Facades\Stream;

trait HasRoutes
{
    /**
     * $_routes
     *
     * @var array
     */
    protected $_routes = [];

    /**
     * __bootRoutes
     *
     * Initialize the routes
     *
     * @author Gustavo Vilas Boas
     * @since 23/11/2020
     */
    public function __bootRoutes()
    {
        foreach ($this->_routes as $route) {
            $this->loadRoutesFrom($route);
        }
    }
}
