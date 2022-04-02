<?php
namespace App\Traits;

use App\Models\Customer;

trait CustomerTrait{
    use fileUploadDeleteTrait;
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
   public function addNewCustomerTrait()
   {
        $customer              = new Customer();
        $customer->user_id     = auth()->user()->id;
        $customer->name        = ucwords($this->name);
        $customer->mobile      = $this->fixedMobile($this->mobile);
        $customer->address     = $this->address ?? null;
        $customer->email       = $this->email ?? null;
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
        $customer->mobile      = $this->fixedMobile($this->mobile);
        $customer->address     = $this->address ?? null;
        $customer->email       = $this->email ?? null;
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
}