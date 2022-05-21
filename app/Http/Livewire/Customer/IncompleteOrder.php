<?php

namespace App\Http\Livewire\Customer;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\OrderManagement;

class IncompleteOrder extends Component
{
    use WithPagination;
    public function render()
    {
        $IncompleteOrder = OrderManagement::where('status','!=','cancled')->where('status','!=','completed')->paginate(10);
        return view('livewire.customer.incomplete-order', compact('IncompleteOrder'))->layout('layouts.starter');
    }
}
