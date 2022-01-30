<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Contracts\Validation\DataAwareRule;

class RequiredAny2 implements Rule, DataAwareRule
{
    protected $data = [];
    protected $options = [];
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($others = "")
    {
        $this->options = (explode(',', $others));
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $this->data = reset($this->data);
        $set = 0;
        if (($value != null && !empty($value)) || $value == false) {
            $set++;
        }
        foreach ($this->options as $item) {
            if((isset($this->data[$item]) && !empty($this->data[$item])) || $this->data[$item] == false) {
                $set++;
            }
        }
        return ($set >= 2);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Any 2 options are required.';
    }

    /**
     * Set the data under validation.
     *
     * @param  array  $data
     * @return $this
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }
}
