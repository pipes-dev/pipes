<?php

namespace Pipes\Stream;

use Illuminate\Pipeline\Pipeline;

class Stream
{
    /**
     * $actions
     *
     * Actions running on the stream
     *
     */
    private $actions = [];

    /**
     * $pipeline
     *
     * Laravel's pipeline instance
     *
     */
    private $pipeline;

    /**
     * __construct
     *
     * @author Gustavo Vilas Boas
     * @since 11/11/2020
     * @param Pipeline $pipeline Laravel's pipeline instance
     * @param array $actions initial actions
     */
    public function __construct(Pipeline $pipeline, array $actions = [])
    {
        $this->pipeline = $pipeline;
        $this->actions = $actions;
    }

    /**
     * getActions
     *
     * Get actions attached to an trigger
     *
     * @author Gustavo Vilas Boas
     * @since 11/11/2020
     * @param string $trigger
     * @return array
     */
    public function getActions(string $trigger): array
    {
        $actions = optional($this->actions)[$trigger] ?? [];
        return collect($actions)->sort(function ($a, $b) {
            $a = isset($a::$priority) ? $a::$priority : 10;
            $b = isset($b::$priority) ? $b::$priority : 10;

            if ($a === $b) {
                return 0;
            }

            return ($a < $b) ? -1 : 1;
        })->toArray();
    }

    /**
     * getTriggers
     *
     * Get all triggers
     *
     * @author Gustavo Vilas Boas
     * @since 11/11/2020
     */
    public function getTriggers()
    {
        return array_keys($this->actions);
    }

    /**
     * attach
     *
     * Attach a action to a trigger
     *
     * @author Gustavo Vilas Boas
     * @since 11/11/2020
     * @param string $trigger the trigger to attach the action
     * @param mixed $aciton the action to attach
     * @return void
     */
    public function attach(string $trigger, $action): void
    {
        if (optional($this->actions)[$trigger]) {
            $this->actions[$trigger][] = $action;

            return;
        }
        $this->actions[$trigger] = [$action];
    }

    /**
     * send
     *
     * Sends an trigger through the pipeline
     *
     * @author Gustavo Vilas Boas
     * @since 11/11/2020
     * @param string $trigger the trigger being dispatched
     * @param mixed $params params that will be processed by the pipeline
     * @return mixed
     */
    public function send(string $trigger, $param = null, $default = null)
    {
        // Get any tasks to run, if exists
        $actions = $this->getActions($trigger);

        // Set a default action to pipeline
        $default = $default ?? function ($args, $next) {
            $next($args);
        };

        // Run the pipeline
        return $this->pipeline->send($param)
            ->through([...$actions, $default])
            ->via('execute')
            ->thenReturn();
    }
}
