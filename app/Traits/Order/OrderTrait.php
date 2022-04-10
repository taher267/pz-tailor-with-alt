<?php
namespace App\Traits\Order;
use App\Models\OrderManagement;

trait OrderTrait {
    public function maxOrderNoFixing($order_number){
        $Order = OrderManagement::orderBy('id',"DESC")->first();
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
        if( count(OrderManagement::all())>0 && ! $this->force_id ){
            $this->minOrderId = OrderManagement::orderBy('id','DESC')->first()->order_number+1;
        }else if(!$this->force_id){
            $this->minOrderId=1;
        }else{
            $this->minOrderId=$this->order_number;
        }
        
    }
    public function placeOrder($customer_id)
    {
        // if (count($this->up_products)+count($this->lo_products)==count($this->wages_selected_products)) {
        //     dd($this->wages_selected_products);
        // }else {
        //     return false;
        // }
        
        // dd($this->upperProductsJsonEncode());
        // if($customer_id){
        //     $order                  = new OrderManagement();
        //     $order->user_id         = auth()->user()->id;
        //     $order->customer_id     = $customer_id;
        //     $order->order_number    = $this->order_number; 
        //     $order->delivery_date   = $this->delivery_date;
        //     $order->wageses           = json_encode([1=>1,2=>2]);
        //     // $order->courier_details = $this->courierDetailsJsonEncode();
        //     $order->status          = 'processing';
        //     dd($order);
        //     // $order->save();
        //     return $order->id;
        // }else{
        //     return false;
        // }
    }


    public function wagesesJsonEncode()
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
    public function wagesesCalculation()
    {
        //panzabi, shart fotual upper dress
        if (isset($this->upper['wages']) && $this->upper['wages'] != null && is_numeric($this->upper['wages']) && isset($this->upper['quantity']) && $this->upper['quantity'] &&  $this->upper['quantity'] != null && is_numeric($this->upper['quantity'])) {
            $this->upper['total'] = $this->upper['quantity'] * $this->upper['wages'] - (isset($this->upper['discount']) && $this->upper['discount'] ? $this->upper['discount']: 0);
        }else {
            $this->upper['total']=0;
        }
        // pazama pannt, trowser lower dress
        if (isset($this->lower['wages']) && $this->lower['wages'] != null && is_numeric($this->lower['wages']) && isset($this->lower['quantity']) && $this->lower['quantity'] &&  $this->lower['quantity'] != null && is_numeric($this->lower['quantity'])) {
                $this->lower['total'] = $this->lower['quantity'] * $this->lower['wages'] - (isset($this->lower['discount']) && $this->lower['discount'] ? $this->lower['discount']: 0);
        }else {
            $this->lower['total']=0;
        }
    }
    public function upperProductsJsonEncode()
    {
        return json_encode([
            'cloth_long'            => $this->cloth_long,
            'cloth_enclosure'       => $this->cloth_enclosure,
            'hand_long'             => $this->hand_long,
            'cloth_shoulder'        => $this->cloth_shoulder,
            'cloth_body'            => $this->cloth_body?$this->cloth_body:'',
            'body_loose'            => $this->body_loose?$this->body_loose:'',
            'cloth_belly'           => $this->cloth_belly?$this->cloth_belly:'',
            'belly_loose'           => $this->belly_loose?$this->belly_loose:'',
            'sleeve_enclosure'      => $this->sleeve_enclosure?$this->sleeve_enclosure:'',
            'sleeve_pasting'        => $this->sleeve_pasting?$this->sleeve_pasting:'',
            'cloth_throat'          => $this->cloth_throat?$this->cloth_throat:'',
            'cloth_collar'          => $this->cloth_collar?$this->cloth_collar:'',
            'collar_measure_type'   => $this->collar_measure_type?$this->collar_measure_type:0,
            'cloth_mora'            => $this->cloth_mora?$this->cloth_mora:'',
            'noke_shoho'            => $this->noke_shoho?$this->noke_shoho:'',
            'cloth_additional'      => $this->cloth_additional?$this->cloth_additional:'',
            'plate_type'            => $this->plate_type,
            'pocket_type'            => $this->pocket_type?$this->pocket_type:'',
        ]);
    }
    
    public function lowerProductsJsonEncode()
    {
        return json_encode([
            'length'                => $this->length?$this->length:'',
            'around_ankle'          => $this->around_ankle?$this->around_ankle:'',//পায়ের মুহুরী
            'thigh_loose'           => $this->thigh_loose?$this->thigh_loose:'',//রান/উরু
            'waist'                 => $this->waist?$this->waist:'',//কোমর
            'crotch'                => $this->crotch?$this->crotch:''//হাই
        ]);
    }
    
}