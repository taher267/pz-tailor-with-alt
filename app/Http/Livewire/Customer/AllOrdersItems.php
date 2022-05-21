<?php

namespace App\Http\Livewire\Customer;

use Livewire\Component;
use App\Models\OrderItem;
use App\Models\DesignItem;
use Livewire\WithPagination;
use App\Models\OrderManagement;

class AllOrdersItems extends Component
{
    use WithPagination;
    public function render()
    {
        $statuses = OrderManagement::orderManagementStatus();
        $itemsDesings = DesignItem::all();
        $ordersItems = OrderItem::orderByDesc('id')->paginate();
        return view('livewire.customer.all-orders-items', compact('ordersItems','statuses','itemsDesings'))->layout('layouts.starter');
    }
}
