<?php

namespace App\Http\Livewire\Admin;

use App\Models\Product;
use Livewire\Component;
use App\Traits\ProductTrait;
use Livewire\WithPagination;

class AdminProducts extends Component
{
    use ProductTrait;
    use WithPagination;
    public $title='যুক্ত', $formType='add', $formShow = false, $name, $slug, $type, $status, $wages, $option, $product_id, $edit_control=false;
    public function mount()
    {
        $this->status=true;
    }
    public function updated($fields)
    {
        $this->validateOnly($fields,$this->commonProductValidationRule());
        if ($this->formType==='add') {
            $this->validateOnly($fields,$this->addProductValidationRule());
        }
        if ($this->formType==='edit') {
            $this->validateOnly($fields,$this->updateProductValidationRule());
        }
    }
    public function addProduct()
    {
        $this->validate($this->commonProductValidationRule());
        $this->validate($this->addProductValidationRule());
        $this->ManageProduct('add');
    }
    public function editProduct($id)
    {   
        $this->product_id = $id;
        $this->formType='edit';
        $product = Product::findOrFail($id);
        
        $this->name = $product->name;
        $this->slug = $product->slug;
        $this->type = $product->type;
        $this->status = $product->status;
        $this->wages = $product->wages;
        $this->option = $product->option;

        $this->formShow = $this->formShow ? false : true;
        $this->dispatchBrowserEvent('show_large', ['data' => true]);
        $this->title = 'হালনাগাদ';
    }
    public function deleteProduct($id)
    {
        $product = Product::destroy($id);
        $this->dispatchBrowserEvent('data_alert', ['data' => false]);
    }
    public function updateProduct()
    {
        $this->validate($this->commonProductValidationRule());
        $this->validate($this->updateProductValidationRule());
        $this->ManageProduct($this->product_id);

    }
    public function formControl()
    {
        $this->fromReset();
        $this->formShow = $this->formShow ? false : true;
        $this->dispatchBrowserEvent('data_alert', ['data' => $this->formShow]);
        // $this->dispatchBrowserEvent('show_large', ['data' => false]);
        $this->title = 'যুক্ত';
    }

    public function render()
    {
        $products = Product::orderByDesc('id')->paginate(10);
        return view('livewire.admin.admin-products', compact('products'))->layout('layouts.starter');
    }
}
