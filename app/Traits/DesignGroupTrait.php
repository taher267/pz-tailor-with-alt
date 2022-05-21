<?php
namespace App\Traits;
use App\Models\DesignGroup;
use Illuminate\Validation\Rule;

trait DesignGroupTrait{
   public function addProductDesignGroupValidationRule()
   {
    return[
        'name'                 => 'required|unique:design_groups',
        'slug'                  => 'required|regex:/^[a-z][-a-z0-9]*$/|unique:design_groups',
     ];  
   }
   public function updateProductDesignGroupValidationRule()
   {
       return[
           'name'                  => ['required',Rule::unique('design_groups')->ignore($this->design_group_id)],
           'slug'                  => ['required','regex:/^[a-z][-a-z0-9]*$/',Rule::unique('design_groups')->ignore($this->design_group_id)]
        ];
   }
   //Product add and update
   public function ManageProductDesignGroup( $activity = 'add' )
   {
    
       if ($activity==='add') {
           $group = new DesignGroup();
       }elseif($activity){
            $group = DesignGroup::find($activity);
       }
       $group->name   = trim($this->name);
       $group->slug   = trim(strtolower($this->slug));
       if($group->save()){
         $this->dispatchBrowserEvent('add_update_form_extend', ['data' => false]);
         $this->fromReset();
         $this->dispatchBrowserEvent('data_form_design', ['data' => false,"success_id"=>$group->id]);
         $this->formShow= false;
         return $group->id;
       }
    //    return false;
       
   }
    public function fromReset()
    {
        $this->name= "";
        $this->slug= "";
        $this->formType='add';        
    }
}