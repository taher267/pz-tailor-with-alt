<?php

namespace App\Http\Livewire\Admin;

use App\Models\Product;
use Livewire\Component;
use App\Models\DesignItem;
use App\Models\DesignGroup;
use Livewire\WithPagination;
use App\Traits\DesignItemTrait;

class AdminProductDesignItem extends Component
{
    use DesignItemTrait;
    use WithPagination;
    public $title='যুক্ত', $formType='add', $formShow = false, $FormShowexCitation=false, $name, $type, $status, $image, $apply_on=[], $design_item_id, $edit_control=false, $add_apply_on_err;

    public function mount()
    {
        $this->status=true;
    }
    /**
     * Error showing 
     */
    public function updated($fields)
    {
        // dd($this->formType);
        if ($this->formType==='add') {
           $this->add_apply_on_err = $this->validateOnly($fields,$this->productDesignItemValidationRule('add'));
        }
        if ($this->formType==='edit') {
            $this->validateOnly($fields,$this->productDesignItemValidationRule('edit'));
        }
    }
    /**
     * Modal/ Add or edit design form controller
     */
    
    public function formControl()
    {
        $this->fromReset();
        $this->resetValidation();
        // $this->FormShowexCitation = $this->FormShowexCitation ? false : true;
        $this->formShow = $this->formShow ? false : true;
        $this->dispatchBrowserEvent('data_alert', ['data' => $this->formShow]);
        $this->title = 'যুক্ত';
    }
    /**
     * Add design item
     */
    public function addProductDesignItem()
    {
        $this->dispatchBrowserEvent('apply_on_data', ['apply_on' => true]);
        $this->validate($this->productDesignItemValidationRule());
        $this->ManageProductDesignItem('add');

    }
    /**
     * Edit design item
     */
    public function editProductDesignItem($id)
    {
        $this->apply_on = [];
        $this->design_item_id = $id;
        $this->formType='edit';
        $design = DesignItem::find($id);
        $apply = json_decode($design->apply_on);
        if($apply){
            $data = [];
            $c=0;
            foreach ($apply as $k => $v) {
                // $c++;
                $data[]=$k;
            }
            
            $this->dispatchBrowserEvent('apply_on_data', ['status' => true, 'data' => $data]);
            $this->apply_on = $data;
        }
        $this->name     = $design->name;
        $this->type     = $design->type;
        $this->status   = $design->status;
        $this->image    = $design->image;
        $this->title = 'হালনাগাদ';
        $this->formShow = $this->formShow ? false : true;
    }

    /**
     * Update design item
     */
    public function updateProductDesignItem()
    {
        $this->validate($this->productDesignItemValidationRule('edit'));
        $this->ManageProductDesignItem($this->design_item_id);
    }

    public function deleteProductDesignItem($id)
    {
        $design = DesignItem::destroy($id);
    }

    public function render()
    {
        return view('livewire.admin.admin-product-design-item', [
            'designItems'   => DesignItem::orderByDesc('id')->paginate(10),
            'products'      => Product::where('status',1)->get(['id','name','slug']),
            'designGroups'   => DesignGroup::get(['name','slug'])
            ])->layout('layouts.starter');
    }
}
