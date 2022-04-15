<?php

namespace App\Http\Livewire\Customer;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\OrderManagement;

class AllOrders extends Component
{
    use WithPagination;
    public function render()
    {
        $orders = OrderManagement::paginate();
        return view('livewire.customer.all-orders', compact('orders'))->layout('layouts.starter');
    }
}
