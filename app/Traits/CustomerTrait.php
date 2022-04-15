<?php
namespace App\Traits;

use App\Models\Customer;
use App\Models\OrderManagement;

trait CustomerTrait{
    use fileUploadDeleteTrait;
    public function maxOrderNoFixing($order_number){
        $Order = Customer::orderBy('order_number',"DESC")->first();
        if($this->force_id==true){
            return $maxOrderNo = $order_number;
        }else{
            if(strlen($Order)>0){
                return $maxOrderNo = $Order->order_number+1;
            }else{
                return $maxOrderNo = 1;
            }
        }
    }
    public function minMaxOrderId()
    {
        
        if( count(Customer::all())>0 && ! $this->force_id ){
            $this->minOrderId = Customer::orderBy('id','DESC')->first()->order_number+1;
        }else if(!$this->force_id){
            $this->maxOrderId=1;
        }else{
            $this->minOrderId=$this->order_number;
        }
        
    }
   public function addNewCustomerTrait()
   {
        $customer              = new Customer();
        $customer->user_id     = auth()->user()->id;
        $customer->name        = ucwords($this->name);
        $customer->mobile      = $this->mobile;
        $customer->address     = $this->address ?? null;
        $customer->email       = $this->email && trim($this->email)!='' ?$this->email: null;
        $customer->order_number= $this->order_number;
        $customer->courier_details = $this->courierDetailsJsonEncode();
        if ($this->photo) {
            // $file,$filename,$uploadOn,$disk, $height, $width
            $customer->photo = $this->fileUploads($this->photo, $this->name,'customers', 'public',150,150);
        }
        if ($customer->save()) {
            return $customer->id;
        }
        return false;
   }
  
   public function UpdateNewCustomerTrait($customer_id)
   {
        $customer              = Customer::find($customer_id);
        $customer->user_id     = auth()->user()->id;
        $customer->name        = ucwords($this->name);
        $customer->mobile      = $this->mobile;
        // $customer->order_number      = $this->order_number;
        $customer->address     = $this->address ?? null;
        $customer->email       = $this->email && trim($this->email)!='' ?$this->email: null;
        if ($this->order_delivery) {
            $customer->courier_details = $this->courierDetailsJsonEncode();
        }
        if ($this->newphoto) {
            /**
             * @param $delform default "customers"
             * @param $disk default 'public'
             */
            if ($this->photo) {
                $this->deleteFileTrait($this->photo);
            }
            //Delete prev photo
            // $file,$filename,$uploadOn,$disk, $height, $width
            $customer->photo = $this->fileUploads($this->newphoto, $this->name,'customers', 'public',150,150);
        }
        if ($customer->save()) {
            return true;
        }
        return false;
   }

    /**
     * HELPER FUNCTION
     */
    public function courierDetailsJsonEncode()
    {
        if ($this->order_delivery) {
            $encdeDelivery= [
                        'delivery_system'   =>$this->delivery_system,
                        'courier_name'       =>$this->courier_name,
                        'delivery_charge'   =>(int)$this->delivery_charge,
                        'country'           =>$this->country,
                        'city'              =>$this->city,
                        'province'          =>$this->province,
                        'line1'             =>$this->line1,
                        'line2'             =>$this->line2,
                        'zipcode'           =>$this->zipcode,
                    ];
            return json_encode($encdeDelivery);
        }else{
            return null;
        }
        
    }
















   public function fixedMobile($mobile)
    {
        $newPhone;
        if (strlen($mobile)===14) {
            $newPhone=$mobile;
        }elseif(strlen($mobile)===13){
            $newPhone='+'.$mobile;
        }else{
            $newPhone='+88'.$mobile;
        }
        return $newPhone;
    }
}