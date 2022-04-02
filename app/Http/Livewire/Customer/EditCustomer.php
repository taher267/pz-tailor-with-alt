<?php

namespace App\Http\Livewire\Customer;

use Livewire\Component;
use App\Models\Customer;
use App\Traits\CustomerTrait;
use Livewire\WithFileUploads;
use Illuminate\Validation\Rule;

class EditCustomer extends Component
{
    use WithFileUploads;
    use CustomerTrait;
    public $name, $mobile, $email, $address,$photo, $newphoto,$customer_id;
    public function mount($id)
    {
        $customer           = Customer::findOrFail($id);
        $this->name         = $customer->name;
        $this->mobile       = $customer->mobile;
        $this->email        = $customer->email;
        $this->address      = $customer->address;
        $this->photo        = $customer->photo;
        $this->customer_id  = $customer->id;
    }
    public function updated($fields)
    {
        $this->validateOnly($fields,[
            'name'      =>  'required|regex:/^[\pL\s\-]+$/u',
            'mobile'    => ['required',"regex:/^(\+88)?(88)?01([0-9]){9}$/",Rule::unique('customers')->ignore($this->customer_id)],
            'email'     =>  ["email","nullable",Rule::unique('customers')->ignore($this->customer_id)],
            'address'   =>  'string|nullable',
            'newphoto'     =>  'image|mimes:jpg,jpeg,png|nullable'
        ],
        // $this->customerErrorMessages($this->email,$this->mobile)
    );
    
    }
    public function upDateCustomer(){
        $this->validate([
            'name'      =>  'required|regex:/^[\pL\s\-]+$/u',
            'mobile'    => ['required',"regex:/^(\+88)?(88)?01([0-9]){9}$/",Rule::unique('customers')->ignore($this->customer_id)],
            'email'     =>  ["email","nullable",Rule::unique('customers')->ignore($this->customer_id)],
            'address'   =>  'String|nullable',
            'newphoto'     =>  'image|mimes:jpg,jpeg,png|nullable'
        ]);
       
        $result = $this->UpdateNewCustomerTrait($this->customer_id);
        // dd('Alhamdu lillh');
    }
    public function render()
    {
        return view('livewire.customer.edit-customer')->layout('layouts.starter');
    }
}
