<?php


namespace Pipes\Eloquent;

use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Support\Traits\Macroable;
use Pipes\Eloquent\Traits\HasTriggers;
use Pipes\Eloquent\Traits\HasRules;
use Illuminate\Support\Str;

class Model extends EloquentModel
{
    use Macroable {
        Macroable::__callStatic as macroCallStatic;
        Macroable::__call as macroCall;
    }
    use HasTriggers;
    use HasRules;

    /**
     * Handle dynamic method calls into the model.
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        if (in_array($method, ['increment', 'decrement'])) {
            return $this->$method(...$parameters);
        }

        $query = $this->newQuery();

        if (static::hasMacro($method) && !method_exists($query, $method)) {
            return $this->macroCall($method, $parameters);
        }

        return $this->forwardCallTo($query, $method, $parameters);
    }

    /**
     * Handle dynamic static method calls into the method.
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return mixed
     */
    public static function __callStatic($method, $parameters)
    {
        if (static::hasMacro($method)) {
            return static::macroCallStatic($method, $parameters);
        }

        return (new static)->$method(...$parameters);
    }

    /**
     * Dynamically retrieve attributes on the model.
     *
     * @param  string  $key
     * @return mixed
     */
    public function __get($key)
    {
        $value = $this->getAttribute($key);

        if ($value !== null) {
            return $value;
        }

        if (static::hasMacro($key)) {
            $value = $this->getRelationshipFromMethod($key);
        }

        return $value;
    }

    /**
     * Determine if a get mutator exists for an attribute.
     *
     * @param  string  $key
     * @return bool
     */
    public function hasGetMutator($key)
    {
        $method = 'get' . Str::studly($key) . 'Attribute';

        if (method_exists($this, $method)) {
            return true;
        }

        return static::hasMacro($method);
    }

    /**
     * Determine if a set mutator exists for an attribute.
     *
     * @param  string  $key
     * @return bool
     */
    public function hasSetMutator($key)
    {
        $method = 'set' . Str::studly($key) . 'Attribute';

        if (method_exists($this, $method)) {
            return true;
        }

        return static::hasMacro($method);
    }
}
