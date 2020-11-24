<?php

namespace Pipes\Eloquent\Actions\Validation;

use Illuminate\Support\Facades\Validator;

class CreatingValidationAction
{
    /**
     * $_triggers
     *
     * Events that trigger this action
     *
     * @var string[]
     */
    public static $triggers = [
        '*::*:creating'
    ];

    /**
     * execute
     *
     * Creates the packages folder in the root
     *
     * @author Gustavo Vilas Boas
     * @since 24/11/2020
     */
    public function execute($model, $next)
    {
        $rules = $model->getValidationRulesOnCreate();

        Validator::validate($model->toArray(), $rules);

        return $next($model);
    }
}
