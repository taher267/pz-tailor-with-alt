<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Customer;

class DashboardTopNavComponent extends Component
{
    public $searchInput;
    public function searching()
    {
        // $this->searchInput=$this->searchInput;
    }
    public function render()
    {
        $searchResult=[];
        if ($this->searchInput) {
            $searchResult = Customer::where('order_number','like', "%{$this->searchInput}%")
            ->orWhere('name','like', "%{$this->searchInput}%")
            ->orWhere('mobile','like', "%{$this->searchInput}%")
            ->orWhere('email','like', "%{$this->searchInput}%")
            ->orderByDesc('id')
            ->get();
        }
        
        return view('livewire.dashboard-top-nav-component',compact('searchResult'));
    }
}
