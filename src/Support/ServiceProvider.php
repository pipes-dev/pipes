<?php

namespace Pipes\Support;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Pipes\Support\Traits\HasActions;

class ServiceProvider extends BaseServiceProvider
{
    use HasActions;

    /**
     * boot
     * 
     * Boot the actions
     * 
     * @author Gustavo Vilas Boas
     */
    public function boot()
    {
        $this->__bootActions(); // Initialize the actions
    }
}
