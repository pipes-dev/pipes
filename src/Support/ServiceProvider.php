<?php

namespace Pipes\Support;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Pipes\Support\Traits\HasActions;
use Pipes\Support\Traits\HasRoutes;

class ServiceProvider extends BaseServiceProvider
{
    use HasActions;
    use HasRoutes;

    /**
     * boot
     *
     * Boot the actions
     *
     * @author Gustavo Vilas Boas
     * @since 11/11/2020
     */
    public function boot()
    {
        $this->__bootActions();
        $this->__bootRoutes();
    }
}
