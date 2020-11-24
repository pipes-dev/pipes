<?php

namespace Pipes\Support\Traits;

trait HasMigrations
{
    /**
     * $_migrations
     *
     * @var array
     */
    protected $_migrations = [];

    /**
     * __bootMigrations
     *
     * Initialize the migrations
     *
     * @author Gustavo Vilas Boas
     * @since 23/11/2020
     */
    public function __bootMigrations()
    {
        foreach ($this->_migrations as $_migrations) {
            $this->loadMigrationsFrom($_migrations);
        }
    }
}
