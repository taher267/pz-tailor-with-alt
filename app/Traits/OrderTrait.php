<?php
namespace App\Traits;
use App\Models\Order;

trait OrderTrait {
    public function maxOrderNoFixing($order_number){
        $Order = Order::orderBy('id',"DESC")->first();
        if($this->force_id==1){
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
        if( count(Order::all())>0 && ! $this->force_id ){
            $this->minOrderId = Order::orderBy('id','DESC')->first()->order_number+1;
        }else if(!$this->force_id){
            $this->minOrderId=1;
        }else{
            $this->minOrderId=$this->order_number;
        }
        
    }
    public function placeOrder($customer_id)
    {
        if($customer_id){
            $order                  = new Order();
            $order->user_id         = auth()->user()->id;
            $order->customer_id     = $customer_id;
            $order->order_number    = $this->order_number; 
            $order->delivery_date   = $this->delivery_date;
            $order->wages           = $this->wagesJsonEncode();
            $order->courier_details = $this->courierDetailsJsonEncode();
            $order->status          = 'processing';
            $order->save();
            return $order->id;
        }else{
            return false;
        }
    }



    public function wagesJsonEncode()
    {
        $order_discount         = $this->discount && $this->discount ? $this->discount : 0;
        $order_advance          = $this->advance && $this->advance ? $this->advance : 0;
        $order_total            = $this->total;
        $calculated             = ['total'=>(int)$order_total, 'discount'=> (int)$order_discount,'advance'=> (int)$order_advance];
        return json_encode($calculated);
    }
    
    public function courierDetailsJsonEncode()
    {
        if ($this->order_delivery) {
            $encdeDelivery= [
                        'delivery_system'   =>$this->delivery_system,
                        'courier_details'   =>$this->courier_details,
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
}
          