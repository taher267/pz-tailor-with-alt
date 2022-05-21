<?php

namespace App\Rules;

use App\Models\OrderManagement;
use Illuminate\Contracts\Validation\Rule;

class ChangeOrderNumber implements Rule
{
    public $data, $numberOfOrder;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data=$data;
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
        $order = OrderManagement::where('order_number',$this->data)->get('id');
        $this->numberOfOrder = count($order);
        return !count($order);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return "The :attribute not able to change due to a number of order($this->numberOfOrder) presents";
    }
}
