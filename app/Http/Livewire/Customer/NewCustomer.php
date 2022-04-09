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
    public $name, $mobile, $email, $address, $photo, $order_number, $maxOrderId,$force_id;
    //Order Delivery
    public $order_delivery, $delivery_system, $courier_name, $delivery_charge, $country="bd", $city, $province, $line1, $line2, $zipcode;
    public function mount()
    {
        // $this->reset();
    }
    public function updated($fields)
    {
        $this->validateOnly($fields,[
            'name'              =>  'required',//|regex:/^[\pL\s\-]+$/u
            'mobile'            =>  'required|unique:customers|regex:/^01([0-9]){9}$/',
            'order_number'      => "required|numeric|unique:customers|min:1|max:".$this->maxOrderNoFixing($this->order_number),
            'email'             =>  'email|nullable|unique:customers',
            'address'           =>  'String|nullable',
            'photo'             =>  'image|mimes:jpg,jpeg,png|nullable',
            'delivery_system'   =>  'required_with:order_delivery|gt:0',
            'delivery_charge'   =>  'required_with:order_delivery|numeric',
            'courier_name'      =>  'required_with:order_delivery',
            'country'           =>  'required_with:order_delivery|in:bd',
            'city'              =>  'required_with:order_delivery|String',
            'line1'             =>  'required_with:order_delivery|String',
            'line2'             =>  'String|nullable',
            'province'          =>  'required_with:order_delivery|String',
            'zipcode'           =>  'required_with:order_delivery|numeric'
        ],
    );
    
    }
    public function addCustomer(){
        $this->validate([
            'name'              =>  'required',//|regex:/^[\pL\s\-]+$/u
            'mobile'            =>  'required|unique:customers|regex:/^01([0-9]){9}$/',
            'order_number'      =>  "required|numeric|unique:customers|min:1|max:".$this->maxOrderNoFixing($this->order_number),
            'email'             =>  'email|nullable|unique:customers',
            'address'           =>  'String|nullable',
            'photo'             =>  'image|mimes:jpg,jpeg,png|nullable'
        ]);
        if ($this->order_delivery) {
            $this->validate([
                'delivery_system'   =>  'required|gt:0',
                'delivery_charge'   =>  'required|numeric',
                'courier_name'      =>  'required',
                'country'           =>  'required|in:bd',
                'city'              =>  'required|String',
                'line1'             =>  'required|String',
                'line2'             =>  'String|nullable',
                'province'          =>  'required|String',
                'zipcode'           =>  'required|numeric'
            ]);
        }
        $result = $this->addNewCustomerTrait();
        
        if ($result) {
            return redirect()->route('customers');
        }
    }
    public function render()
    {
        $this->minMaxOrderId();
        return view('livewire.customer.new-customer')->layout('layouts.starter');
    }
}
