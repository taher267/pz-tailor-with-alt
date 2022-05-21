<?php

namespace App\Http\Livewire\Customer;

use Livewire\Component;
use App\Models\Customer;
use Livewire\WithPagination;
use App\Traits\fileUploadDeleteTrait;

class AllCustomers extends Component
{
    use WithPagination;
    use fileUploadDeleteTrait;
    public function deleteCustomer($id)
    {
        $photo = Customer::find($id)->photo;
        
        // $customer = Customer::destroy($id);
        
        if($photo && $customer){
            $this->deleteFileTrait($photo);
        }
    }
    public function render()
    {
        $allCustomers= Customer::orderBy('created_at', "DESC")->paginate(10);
        return view('livewire.customer.all-customers',compact('allCustomers'))->layout('layouts.starter');
    }
}
