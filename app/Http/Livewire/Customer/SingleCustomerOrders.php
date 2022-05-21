<?php

namespace App\Http\Livewire\Customer;

use Livewire\Component;
use App\Models\Customer;
use App\Models\OrderManagement;

class SingleCustomerOrders extends Component
{   
    public $order_number, $name, $mobile, $email, $address, $photo;
    public function mount($order_number)
    {
        $customer = Customer::where('order_number', $order_number)->firstOrFail();
        $this->order_number     = $order_number;
        $this->name             = $customer->name;
        $this->mobile           = $customer->mobile;
        $this->email            = $customer->email;
        $this->address          = $customer->address;
        $this->photo            = $customer->photo;

        // dd(gettype(OrderManagement::where('order_number', $order_number)->latest()->orderByDesc('id')->get()));
    }
    public function render()
    {
        $orders = OrderManagement::where('order_number', $this->order_number)->latest()->orderByDesc('id')->paginate(10);
        return view('livewire.customer.single-customer-orders',compact('orders'))->layout('layouts.starter');
    }
}
