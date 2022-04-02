<?php

namespace App\Http\Livewire\Manage;

use Livewire\Component;

class ManageDashboardComponent extends Component
{
    public function render()
    {
        return view('livewire.manage.manage-dashboard-component')->layout('layouts.starter');
    }
}
