<?php

namespace App\Http\Livewire\Customer;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\OrderManagement;

class CustomerOrders extends Component
{
    use WithPagination;
    public $order_status="", $change_order_status=[];
    public function mount($status=null)
    {
        $this->order_status = $status;
    }
    public function changeOrderStatus($id)
    {
        $order = OrderManagement::find($id);
        $order->status = $this->change_order_status[$id];
        // ;
        if ($order->save()) {
            foreach ($order->orderItems as $item) {
                $item->status = $this->change_order_status[$id];
                $item->save();
            }
        }

    }
    public function render()
    {
        $statuses = OrderManagement::orderManagementStatus();
            $specificorders;
        if (!$this->order_status || $this->order_status==='all') {
            $specificorders = OrderManagement::paginate(10);
        }else if ($this->order_status==='unaccomplished') {
            $specificorders = OrderManagement::where('status','!=','completed')->where('status','!=','cancled')->paginate(10);
        }else {
            $specificorders = OrderManagement::where('status', $this->order_status)->paginate(10);
        }
        return view('livewire.customer.customer-orders', compact('specificorders', 'statuses'))->layout('layouts.starter');
    }
}
