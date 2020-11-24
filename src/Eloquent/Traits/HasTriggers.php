<?php

namespace Pipes\Eloquent\Traits;

use Pipes\Stream\Facades\Stream;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

trait HasTriggers
{
    /**
     * $__triggers
     * 
     * All models trigger
     * 
     * @var array $__triggers
     */
    private static $__triggers = [
        'replicating',
        'retrieved',
        'creating',
        'deleting',
        'updating',
        'created',
        'updated',
        'deleted',
        'saving',
        'saved',
    ];

    /**
     * _guessNameSpace
     * 
     * Guess model triggers namespace
     * 
     * @author Gustavo Vilas Boas
     * @since 11/11/2020
     * @return string
     */
    public static function getNameSpace(): string
    {
        $namespace = static::class;

        $parts = explode('\\', $namespace);

        return Str::snake($parts[1]) . '::' . Str::snake(Arr::last($parts));
    }

    /**
     * bootHasTriggers
     * 
     * Boot triggers from this model
     * 
     * @author Gustavo Vilas Boas
     * @since 13/11/2020
     */
    public static function bootHasTriggers()
    {
        $namespace = static::getNameSpace();

        Stream::send($namespace . ":boot", static::class);

        foreach (static::$__triggers as $trigger) {
            static::{$trigger}(function ($model) use ($trigger, $namespace) {
                Stream::send($namespace . ":{$trigger}", $model);
            });
        }
    }

    /**
     * initializeHasTriggers
     * 
     * Dispatch initialized event
     * 
     * @author Gustavo Vilas Boas
     * @since 13/11/2020
     */
    protected function initializeHasTriggers()
    {
        Stream::send(static::getNameSpace() . ":init", $this);
    }
}
