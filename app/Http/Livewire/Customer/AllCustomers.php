<?php

namespace App\Http\Livewire\Customer;

use Livewire\Component;
use App\Models\Customer;
use Livewire\WithPagination;

class AllCustomers extends Component
{
    use WithPagination;
    public function render()
    {
        $allCustomers= Customer::orderBy('created_at', "DESC")->paginate(10);
        return view('livewire.customer.all-customers',compact('allCustomers'))->layout('layouts.starter');
    }
}
