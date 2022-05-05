<?php

namespace App\Http\Livewire\Customer;

use Livewire\Component;
use App\Models\OrderItem;
use App\Models\DesignItem;
use Livewire\WithPagination;
use App\Models\OrderManagement;
use App\Traits\Order\OrderTrait;

class CustomerOrderItems extends Component
{
    use WithPagination;
    use OrderTrait;
    public $order_number, $order_management_id, $change_order_item_status=[];

    public function mount($order_number, $order_management_id )
    {
        $this->order_number= $order_number;
        $this->order_management_id= $order_management_id;
        
    }
    public function changeOrderItemStatus($id)
    {
     $this->changeOrderItemStatusWithOrderManagement($id, $this->change_order_item_status[$id], true);
     $this->change_order_item_status[$id] = $this->change_order_item_status[$id];
    

    }
    public function render()
    {
        $statuses = OrderManagement::orderManagementStatus();
        $itemsDesings = DesignItem::all();
        $orderItems = OrderItem::where('order_number', $this->order_number)->where('order_management_id', $this->order_management_id)->paginate(5);
        return view('livewire.customer.customer-order-items', compact('orderItems', 'itemsDesings', 'statuses'))->layout('layouts.starter');
    }
}
