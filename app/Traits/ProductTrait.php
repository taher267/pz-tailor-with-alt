<?php
namespace App\Traits;
use App\Models\Product;
use Illuminate\Validation\Rule;

trait ProductTrait{
   public function commonProductValidationRule()
   {
       return[
        'type'                  => 'required|string|not_in:0',
        'status'                => 'required|boolean',
        'wages'                 => 'nullable|numeric',
        'option'                => 'nullable|string',
       ];
   }
   public function addProductValidationRule()
   {
       return[
           'name'                 => 'required|unique:products',
           'slug'                  => 'required|alpha_dash|unique:products',
        ];
   }
   public function updateProductValidationRule()
   {
       return[
           'name'                  => ['required',Rule::unique('products')->ignore($this->product_id)],
           'slug'                  => ['required',Rule::unique('products')->ignore($this->product_id)]
        ];
   }
   //Product add and update
   public function ManageProduct($activity = 'add')
   {
       if ($activity==='add') {
           $product = new Product();
       }elseif($activity){
            $product = Product::find($activity);
       }
       $product->name   = $this->name;
       $product->slug   = $this->slug;
       $product->type   = $this->type;
       $product->status = $this->status;
       $product->wages  = $this->wages && $this->wages?$this->wages:0;
       $product->option = $this->option;
       if($product->save()){
         $this->dispatchBrowserEvent('show_large', ['data' => false]);
         $this->fromReset();
         $this->dispatchBrowserEvent('data_alert', ['data' => false,"success_id"=>$product->id]);
         $this->formShow= false;
         return $product->id;
       }
    //    return false;
       
   }
    public function fromReset()
    {
        $this->name= "";
        $this->slug= "";
        $this->type= "";
        $this->status= 1;
        $this->wages= "";
        $this->option= "";
        $this->formType='add';        
    }
}