<?php

namespace App\Rules\Admin;

use Illuminate\Contracts\Validation\Rule;

class ValidPromotionInventory implements Rule {
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    private $message = 'Inventory data is invalid';
    public function __construct() {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value) {
        \Log::info($attribute);
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message() {
        return $this->message;
    }
}
