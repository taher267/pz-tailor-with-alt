<?php

namespace App\Http\Livewire\Customer;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\OrderManagement;

class SpecificOrders extends Component
{
    use WithPagination;
    public $order_status="processing", $change_order_status=[];
    public function changeOrderStatus($id)
    {
        $order = OrderManagement::find($id);
        $order->status = $this->change_order_status[$id];
        $order->save();
    }
    public function render()
    {
        $statuses = OrderManagement::orderManagementStatus();
        $specificorders = OrderManagement::where('status', $this->order_status)->paginate(10);
        return view('livewire.customer.specific-orders', compact('specificorders', 'statuses'))->layout('layouts.starter');
    }
}
