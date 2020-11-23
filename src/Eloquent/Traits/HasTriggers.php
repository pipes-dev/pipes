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
    protected static function _getNameSpace(): string
    {
        $namespace = get_class(resolve(static::class));

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
        $namespace = static::_getNameSpace();

        Stream::send($namespace . ":boot", static::class);

        foreach (static::$__triggers as $trigger) {
            static::{$trigger}(function ($model) use ($trigger, $namespace) {
                Stream::send($namespace . ":{$trigger}", $model);
            });
        }
    }
}
