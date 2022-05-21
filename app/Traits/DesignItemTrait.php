<?php
namespace App\Traits;
use App\Models\DesignItem;
use Illuminate\Validation\Rule;

trait DesignItemTrait{
   
   //Product add and update
   public function ManageProductDesignItem($activity = 'add')
   {
       if ($activity==='add') {
           $design = new DesignItem();
       }elseif($activity){
            $design = DesignItem::find($activity);
       }
       
       $design->name       = trim($this->name);
       $design->type       = trim($this->type);
       $design->status     = trim($this->status);
       $design->apply_on   = $this->decodeApplyOnData($this->apply_on);
       $design->image      = trim($this->image)?trim($this->image):null;
       if($design->save()){
         $this->fromReset();
         $this->dispatchBrowserEvent('data_alert', ['data' => false,"success_id"=>$design->id]);//data_form_design
         $this->formShow= false;
         return $design->id;
       };
       
   }
    public function decodeApplyOnData($data)
    {
        $arr=[];
        foreach ($data as $k => $v) {
            $arr[$v]=1;
        }
        return json_encode($arr,JSON_UNESCAPED_UNICODE);
    }
    public function fromReset()
    {
        $this->name= "";
        $this->type= "";
        $this->status= 1;
        $this->apply_on= "";
        $this->image= "";
        $this->formType='add';        
    }


    public function productDesignItemValidationRule($param=null)
   {
       $arr=[
        'type'                  => 'required|string|not_in:0',
        'status'                => 'required|boolean',
        'apply_on'              => 'required|array|min:1',
        'image'                 => 'nullable|image|mimes:jpg,jpeg,png'
       ];
        if($param === 'edit'){
           $arr=array_merge($arr,['name' => ['required',Rule::unique('design_items')->ignore($this->design_item_id)]]);
        }else{
           $arr=array_merge($arr,['name' => 'required|unique:design_items']);
        }
       return $arr;
   }
}