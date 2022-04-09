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
    public $name, $mobile, $email, $address, $photo, $newphoto, $order_number, $maxOrderId,$force_id,$customer_id;
    //Order Delivery
    public $order_delivery, $delivery_system, $courier_name, $old_courier_name, $delivery_charge, $country, $city, $province, $line1, $line2, $zipcode;

    public function mount($id)
    {
        $customer               = Customer::findOrFail($id);
        $this->order_number     = $customer->order_number;
        $this->name             = $customer->name;
        $this->mobile           = $customer->mobile;
        $this->email            = $customer->email;
        $this->address          = $customer->address;
        $this->photo            = $customer->photo;
        
        if ($customer->courier_details) {
            $this->order_delivery = 1;
            $details = json_decode($customer->courier_details);
            $this->courier_name     = $details->courier_name;
            $this->delivery_system  = $details->delivery_system;
            $this->delivery_charge  = $details->delivery_charge;
            $this->country          = $details->country;
            $this->city             = $details->city;
            $this->province         = $details->province;
            $this->line1            = $details->line1;
            $this->line2            = isset($details->line2)?$details->line2:null;
            $this->zipcode          = $details->zipcode;
        }
        $this->customer_id      = $customer->id;
    }
    public function updated($fields)
    {
        $this->validateOnly($fields,[
            'order_number'  =>  ["required","numeric","min:1","max:".$this->maxOrderNoFixing($this->order_number),Rule::unique('customers')->ignore($this->customer_id)],
            'name'          =>  'required',
            'mobile'        =>  ['required',"regex:/^01([0-9]){9}$/",Rule::unique('customers')->ignore($this->customer_id)],
            'email'         =>  ["email","nullable",Rule::unique('customers')->ignore($this->customer_id)],
            'address'       =>  'string|nullable',
            'newphoto'      =>  'image|mimes:jpg,jpeg,png|nullable',
        ],);
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
    
    }
    public function upDateCustomer(){
        $this->validate([
            'name'      =>  'required',
            'mobile'    => ['required',"regex:/^(\+88)?(88)?01([0-9]){9}$/",Rule::unique('customers')->ignore($this->customer_id)],
            'email'     =>  ["email","nullable",Rule::unique('customers')->ignore($this->customer_id)],
            'address'   =>  'String|nullable',
            'newphoto'  =>  'image|mimes:jpg,jpeg,png|nullable'
        ]);
        $result = $this->UpdateNewCustomerTrait($this->customer_id);
    }
    public function render()
    {
        $this->minMaxOrderId();
        return view('livewire.customer.edit-customer')->layout('layouts.starter');
    }
}
