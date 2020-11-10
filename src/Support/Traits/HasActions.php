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
     */
    public function __bootActions()
    {
        foreach ($this->_actions as $event => $actions) {
            foreach ($actions as $action) {
                Stream::attach($event, $action);
            }
        }
    }
}
