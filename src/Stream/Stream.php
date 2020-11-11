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
     * Get actions attached to an event
     *
     * @author Gustavo Vilas Boas
     * @param string $event
     * @return array
     */
    public function getActions(string $event): array
    {
        return optional($this->actions)[$event] ?? [];
    }

    /**
     * attach
     *
     * Attach a action to a event
     *
     * @author Gustavo Vilas Boas
     * @param string $event the event to attach the action
     * @param mixed $aciton the action to attach
     * @return void
     */
    public function attach(string $event, $action): void
    {
        if (optional($this->actions)[$event]) {
            $this->actions[$event][] = $action;

            return;
        }
        $this->actions[$event] = [$action];
    }

    /**
     * send
     *
     * Sends an event through the pipeline
     *
     * @author Gustavo Vilas Boas
     * @param string $event the event being dispatched
     * @param mixed $params params that will be processed by the pipeline
     * @return mixed
     */
    public function send(string $event, $param = null)
    {
        // Get any tasks to run, if exists
        $actions = $this->getActions($event);

        // Run the pipeline
        return $this->pipeline->send($param)
            ->through($actions)
            ->via('execute')
            ->thenReturn();
    }
}
