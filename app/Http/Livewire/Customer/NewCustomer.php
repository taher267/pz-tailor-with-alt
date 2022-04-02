<?php

namespace App\Http\Livewire\Customer;

use Livewire\Component;
use App\Traits\CustomerTrait;
use Livewire\WithFileUploads;
use App\Traits\fileUploadDeleteTrait;
use App\Traits\ErrorMessageTrait;

class NewCustomer extends Component
{
    use WithFileUploads;
    use fileUploadDeleteTrait;
    use ErrorMessageTrait;
    use CustomerTrait;
    public $name, $mobile, $email, $address,$photo;
    public function mount()
    {
        // $this->reset();
    }
    public function updated($fields)
    {
        $this->validateOnly($fields,[
            'name'      =>  'required|regex:/^[\pL\s\-]+$/u',
            'mobile'    => 'required|unique:customers|regex:/^(\+88)?(88)?01([0-9]){9}$/',
            'email'     =>  'email|nullable|unique:customers',
            'address'   =>  'String|nullable',
            'photo'     =>  'image|mimes:jpg,jpeg,png|nullable'
        ],
        // $this->customerErrorMessages($this->email,$this->mobile)
    );
    
    }
    public function addCustomer(){
        $this->validate([
            'name'      =>  'required|regex:/^[\pL\s\-]+$/u',
            'mobile'    =>  'required|unique:customers|regex:/^(\+88)?(88)?01([0-9]){9}$/',
            'email'     =>  'email|nullable|unique:customers',
            'address'   =>  'String|nullable',
            'photo'     =>  'image|mimes:jpg,jpeg,png|nullable'
        ]);
       
        $result = $this->addNewCustomerTrait();
        if ($result) {
            return redirect()->route('customers');
        }
    }
    public function render()
    {
        return view('livewire.customer.new-customer')->layout('layouts.starter');
    }
}
