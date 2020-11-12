<?php

namespace Pipes\Support\Traits;

use Pipes\Stream\Facades\Stream;

trait HasActions
{
    /**
     * $tasks
     *
     * @var array
     */
    protected $_actions = [];

    /**
     * __bootActions
     *
     * Initialize the actions
     *
     * @author Gustavo Vilas Boas
     * @since 11/11/2020
     */
    public function __bootActions()
    {
        foreach ($this->_actions as $action) {
            foreach ($action::$triggers as $event) {
                Stream::attach($event, $action);
            }
        }
    }
}
