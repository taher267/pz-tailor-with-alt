<?php

namespace App\Http\Livewire\Manage;

use Livewire\Component;
use App\Models\Customer;
use App\Models\OrderManagement;

class ManageDashboardComponent extends Component
{
    public $prevDay=0, $nextDay=3;

    public function mount()
    {
        
    }
    public function dayChanger()
    {
      
    }
    public function FunctionName()
    {
        // OrderManagement::whereBetween( 'delivery_date',[$CarbonstartingDate, $CarbonEndingDate])->get();
    }
    public function render()
    {
        return view('livewire.manage.manage-dashboard-component',['orders'=>OrderManagement::all(), 'customers'=>Customer::all()])->layout('layouts.starter');
    }
}
