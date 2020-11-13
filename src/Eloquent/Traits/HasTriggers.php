<?php

namespace Pipes\Eloquent\Traits;

use Pipes\Stream\Facades\Stream;

trait HasTriggers
{
    /**
     * $_namespace
     * 
     * @var string
     */
    protected static $_namespace = '';

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
     * bootHasTriggers
     * 
     * Boot triggers from this model
     * 
     * @author Gustavo Vilas Boas
     * @since 13/11/2020
     */
    public static function bootHasTriggers()
    {
        Stream::send(static::$_namespace . ":boot", static::class);

        foreach (static::$__triggers as $__trigger) {
            static::{$__trigger}(function ($model) use ($__trigger) {
                Stream::send(static::$_namespace . ":{$__trigger}", $model);
            });
        }
    }
}
