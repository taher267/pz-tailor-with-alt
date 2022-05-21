<?php

namespace App\Http\Livewire\Admin;
use Livewire\Component;
use App\Models\DesignGroup;
use App\Traits\DesignGroupTrait;
use Livewire\WithPagination;

class AdminProductDesignGroup extends Component
{
    use DesignGroupTrait;
    use WithPagination;
    public $title='যুক্ত', $formType='add', $formShow = false, $name, $slug, $design_group_id, $edit_control=false;
    public function updated($fields)
    {   if ($this->formType==='add') {
            $this->validateOnly($fields,$this->addProductDesignGroupValidationRule());
        }
        if ($this->formType==='edit') {
            $this->validateOnly($fields,$this->updateProductDesignGroupValidationRule());
        }
    }
    public function addProductDisgnGroup()
    {
        $this->validate($this->addProductDesignGroupValidationRule());
        $this->ManageProductDesignGroup('add');
    }
    public function editProductDisgnGroup($id)
    {   
        $this->design_group_id = $id;
        $this->formType='edit';
        $product = DesignGroup::findOrFail($id);
        $this->name = $product->name;
        $this->slug = $product->slug;

        $this->formShow = $this->formShow ? false : true;
        $this->dispatchBrowserEvent('show_large', ['data' => true]);
        $this->title = 'হালনাগাদ';
    }
    public function deleteProductDesignGroup($id)
    {
        $product = DesignGroup::destroy($id);
        $this->dispatchBrowserEvent('data_alert', ['data' => false]);
    }
    public function updateProductDisgnGroup()
    {
        $this->validate($this->updateProductDesignGroupValidationRule());
        $this->ManageProductDesignGroup($this->design_group_id);

    }
    public function formControl()
    {
        $this->fromReset();
        $this->formShow = $this->formShow ? false : true;
        $this->dispatchBrowserEvent('data_alert', ['data' => $this->formShow]);
        $this->title = 'যুক্ত';
    }

    public function render()
    {
        return view('livewire.admin.admin-product-design-group', ['designGroups'=>DesignGroup::orderByDesc('id')->paginate(10)])->layout('layouts.starter');
    }
}
