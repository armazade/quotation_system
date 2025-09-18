<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class BooleanRule implements Rule
{
    private ?bool $requiresValue = null;

    private ?string $messageValue = null;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(?bool $requiresValue = null)
    {
        $this->requiresValue = $requiresValue;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        $boolean = static::to_boolean($value);

        if (!is_bool($boolean)) {
            return false;
        }

        if (isset($this->requiresValue) && $this->requiresValue !== $boolean) {
            $this->messageValue = 'Value must be ' . ($this->requiresValue ? 'yes' : 'no');

            return false;
        }

        return true;
    }

    public static function to_boolean($booleable)
    {
        return filter_var($booleable, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        if (isset($this->messageValue)) {
            return $this->messageValue;
        }

        return 'The checkbox is required';
    }
}
