<?php

namespace Pipes\Eloquent\Traits;

trait HasRules
{
    /**
     * __callIfValidationExists
     * 
     * Call a method if the validation exists
     * 
     * @author Gustavo Vilas Bôas
     * @since 24/11/2020
     */
    private function __callIfValidationExists(string $method)
    {
        if (method_exists($this, $method)) {
            return $this->{$method}();
        }

        if (isset($this->{$method})) {
            return $this->{$method};
        }

        return [];
    }

    /**
     * getValidationRulesOnCreate
     * 
     * Get all validation that must be applied on create
     *
     * @author Gustavo Vilas Bôas
     * @since 24/11/2020
     * @return array
     */
    public function getValidationRulesOnCreate()
    {
        return array_merge(
            $this->__callIfValidationExists('validationRulesOnSave'),
            $this->__callIfValidationExists('validationRulesOnCreate'),
        );
    }

    /**
     * getValidationRulesOnUpdate
     * 
     * Get all validations that must be applied on update
     * 
     * @author Gustavo Vilas Bôas
     * @since 24/11/2020
     * @return array
     */
    public function getValidationRulesOnUpdate()
    {
        return array_merge(
            $this->__callIfValidationExists('validationRulesOnSave'),
            $this->__callIfValidationExists('validationRulesOnUpdate')
        );
    }
}
