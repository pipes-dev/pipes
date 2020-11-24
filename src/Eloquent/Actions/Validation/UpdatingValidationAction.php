<?php

namespace Pipes\Eloquent\Actions\Validation;

use Illuminate\Support\Facades\Validator;

class UpdatingValidationAction
{
    /**
     * $_triggers
     *
     * Events that trigger this action
     *
     * @var string[]
     */
    public static $triggers = [
        '*::*:updating'
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
        $rules = $model->getValidationRulesOnUpdate();

        Validator::validate($model->toArray(), $rules);

        return $next($model);
    }
}
