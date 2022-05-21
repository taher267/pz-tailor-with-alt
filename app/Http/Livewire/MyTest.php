<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\DesignItem;
use App\Models\DesignGroup;

class MyTest extends Component
{
    public function render()
    {
        $isPresent="শর্ট-পাঞ্জাবী";
        $designGroup = DesignGroup::get();
        $designsItems = DesignItem::where('status',1)->where('apply_on','like', "%{$isPresent}%")->get();
        return view('livewire.my-test', compact('designsItems', 'designGroup'));
    }
}
