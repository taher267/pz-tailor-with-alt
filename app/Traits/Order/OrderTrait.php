<?php
namespace App\Traits\Order;
use App\Models\OrderItem;
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
        $subtotal = ($this->up_products && $this->up_products && isset($this->upper['total']) && $this->upper['total']!=''?(int)$this->upper['total']:0) + ($this->lo_products && $this->lo_products && isset($this->lower['total']) && $this->lower['total']!=''?(int)$this->lower['total']:0);

        if($this->order_management_id){
            $increaseOrder = OrderManagement::find($this->order_management_id);
            $increaseOrder->wageses = json_encode(['subtotal'=>json_decode($increaseOrder->wageses)->subtotal + $subtotal]);
            $increaseOrder->save();
            return $this->placeOrderItem($this->order_management_id);
        }else {
            $order                  = new OrderManagement();
            $order->user_id         = auth()->user()->id;
            $order->customer_id     = $customer_id;
            $order->order_number    = $this->order_number;
            $order->order_date      = $this->order_date;
            $order->delivery_date   = $this->delivery_date;
            $order->order_summary   = $this->orderSummary();
            $order->wageses         = json_encode(['subtotal'=>$subtotal]);
            if ($this->up_status && $this->up_status!=='processing' && $this->up_status!=='cancled') {
                $order->status          = $this->up_status;
            }elseif ( $this->lo_status && $this->lo_status!=='processing' && $this->lo_status!=='cancled' ) {
                $order->status          = $this->lo_status;
            }else {
                $order->status          = 'processing';
            }
            
            if ($order->save()) {
                return $this->placeOrderItem($order->id);
            }else{
                return 'new-order-failed';
            }
        }
       
    }
    public function orderSummary($encoded=null)
    {
        $upper=0;
        $lower=0;
        if ($this->up_products && $this->up_products) {
            $upper = (int)$this->upper['quantity'];
        }
        
        if ($this->lo_products && $this->lo_products) {
            $lower = (int)$this->lower['quantity'];
        }
        return json_encode([
            'upper'=> $upper,
            'lower'=> $lower,
        ]);
    }
    public function updateOrderSummary($encoded=null)
    {
        
        $orderItems = OrderItem::where('order_management_id',$this->order_management_id)->get();
        $upper=0;
        $lower=0;
        
        foreach ($orderItems as $item) {
            if ($item->type==='upper') {
                $upper+=json_decode($item->item_summary)->quantity;
            }else{
                $lower+=json_decode($item->item_summary)->quantity; 
            }
        }    
        $updateOrderManagement = OrderManagement::find($this->item_group->id);
        $updateOrderManagement->order_summary = json_encode([
            'upper'=> $upper,
            'lower'=> $lower,
        ]);
        $updateOrderManagement->save();
        
    }
    
    // public function updateOrderSummary($encoded=null)
    // {
        
    //     $order = OrderManagement::find($this->order_management_id);
    //     $upper=json_decode($order->order_summary)->upper;
    //     $lower=json_decode($order->order_summary)->lower;

    //     if (isset($this->up_products)&& $this->up_products && $this->up_products) {
    //         $upper = $upper + (int)$this->upper['quantity'];
    //     }
        
    //     if (isset($this->lo_products) && $this->lo_products && $this->lo_products) {
    //         $lower = $lower + (int)$this->lower['quantity'];
    //     }
    //     return json_encode([
    //         'upper'=> $upper,
    //         'lower'=> $lower,
    //     ]);
    // }
    /**
     * অর্ডার আইটেম যুক্তকরা 
     */
    public function placeOrderItem($order_management_id, $update=null, $added = 0)
    {
        
        if (isset($this->up_products) && $this->up_products && $this->up_products) {
            if ($update) {
                $order_item = OrderItem::find($update);
                $this->changeOrderItemStatusWithOrderManagement($update, $this->up_status);
            }else {
                $order_item = new OrderItem();
            }
            $order_item->user_id                = auth()->user()->id;
            $order_item->order_number           = $this->order_number;
            $order_item->order_management_id    = $order_management_id;
            $order_item->type                   = 'upper';
            $order_item->item_summary           = json_encode(['products'=>$this->up_products, 'quantity'=>(int)$this->upper['quantity'], 'wages'=>$this->upperWagesJsonEncode()]);
            $order_item->measurement            = $this->upperMeasurementJsonEncode('encode');
            $order_item->designs                = $this->upperDesignsJsonEncode('encode');
            if ($this->up_status && $this->up_status) {
                $order_item->status                 = $this->up_status;
            }
            
            if ($order_item->save()) {
                if ($update) {
                    $this->updateOrderSummary();
                }
                $added = $added+1;
            }

        }
        if ( isset($this->lo_products ) && $this->lo_products && $this->lo_products) {
            if ($update) {
                $order_item = OrderItem::find($update);
                $this->changeOrderItemStatusWithOrderManagement($update, $this->lo_products);
                // $itGroup = $order_item->itemGroup;
                // $itGroup->order_summary = json_encode([
                //     'upper'=>0,
                //     'lower'=> json_decode($order_item->itemGroup->order_summary)->lower+$this->lower['quantity']-$this->prev_qty
                // ]);
                // $itGroup->save();

            }else {
                $order_item = new OrderItem();
                $order_item->user_id                = auth()->user()->id;
                $order_item->order_management_id    = $order_management_id;
                $order_item->order_number           = $this->order_number;
                $order_item->type                   = 'lower';            
            }            
            $order_item->item_summary           = json_encode(['products'=>$this->lo_products, 'quantity'=>(int)$this->lower['quantity'],'wages'=>$this->lowerWagesJsonEncode()]);
            $order_item->measurement            = $this->lowerMeasurementJsonEncode('encode');
            $order_item->designs                = $this->lowerDesignsJsonEncode('encode');
            if ($this->lo_status && $this->lo_status) {
                $order_item->status                 = $this->lo_status;
            }            
            if($order_item->save()){
                if ($update) {
                    $this->updateOrderSummary();
                }
                $added=$added+1;
            }
        }
        return $added;
    }
    /**
     * UPPER PART START
     */

    public function upperMeasurementJsonEncode($encoded=null)
    {
        if ($this->up_products!=null || $this->up_products!=0) {
            $cloth_collar = $this->cloth_collar;
           if ($this->collar_measure_type==1) {
            $cloth_collar = json_encode(['collar'=> $this->cloth_collar, 'type' => $this->collar_measure_type]);
           }
            $calculated  = [
                'product'=>$this->up_products,
                'cloth_long'            => $this->cloth_long,
                'cloth_enclosure'       => $this->cloth_enclosure,
                'hand_long'             => $this->hand_long,
                'cloth_shoulder'        => $this->cloth_shoulder,
                'cloth_body'            => $this->cloth_body,//?$this->cloth_body:''
                'body_loose'            => $this->body_loose,//?$this->body_loose:''
                'cloth_belly'           => $this->cloth_belly,//?$this->cloth_belly:''
                'belly_loose'           => $this->belly_loose,//?$this->belly_loose:''
                'sleeve_enclosure'      => $this->sleeve_enclosure,//?$this->sleeve_enclosure:''
                'sleeve_pasting'        => $this->sleeve_pasting,//?$this->sleeve_pasting:''
                'cloth_throat'          => $this->cloth_throat,//?$this->cloth_throat:''
                'cloth_collar'          => $cloth_collar,
                'cloth_mora'            => $this->cloth_mora,//?$this->cloth_mora:''
                'noke_shoho'            => $this->noke_shoho,//?$this->noke_shoho:''
                'cloth_additional'      => $this->cloth_additional,//?$this->cloth_additional:''
                'plate'                 => $this->plate != null && count(array_filter($this->plate))>0 ? json_encode($this->plate):null,
                'pocket'                => $this->pocket != null && count(array_filter($this->pocket))>0 ? json_encode($this->pocket):null,
            ];
            if ($encoded==='encode') {
                return json_encode($calculated);
            }
            return $calculated;
        }else{
            return null;
        }         

    }
    // upper design json conversion
    public function upperDesignsJsonEncode($encoded='encode'){
        if ($this->up_design_fields!=null && count(array_filter($this->up_design_fields))>0) {
            $result = [];
            foreach(array_filter($this->up_design_fields) as $k=> $val){
                $result[$k]=trim($val)!='' ? trim($val):null;
            }
            if ($encoded='encode') {
                return json_encode($result);
            }else {
                return $result;
            }
        }else {
            return null;
        }
        
    }
   //upper wages json 
    public function upperWagesJsonEncode($encoded=null)
    {
        if (isset($this->upper['total']) && ($this->up_products!=null || $this->up_products!=0)) {
            $order_discount         = isset($this->upper['discount']) && $this->upper['discount'] && $this->upper['discount'] ? $this->upper['discount'] : 0;
            $order_advance          = isset($this->upper['advance']) && $this->upper['advance'] && $this->upper['advance'] ? $this->upper['advance'] : 0;
            $order_total            = $this->upper['total'];
            $calculated             = ['total'=>(int)$order_total, 'discount'=> (int)$order_discount,'advance'=> (int)$order_advance];
            if ($encoded==='encode') {
                return json_encode($calculated);
            }
            return $calculated;
        }else{
            return 0;
        }         

    }
    /**
     * UPPER PART END
     */
    //=====================================================================
    /**
     * LOWER PART START
     */
    public function lowerMeasurementJsonEncode($encoded='encode')
    {
        
        if ($this->lo_products && $this->lo_products) {
            $result=[
                'product'               => $this->lo_products,
                'length'                => $this->length,
                'around_ankle'          => $this->around_ankle,//পায়ের মুহুরী
                'thigh_loose'           => $this->thigh_loose,//রান/উরু
                'waist'                 => $this->waist,//কোমর
                'crotch'                => $this->crotch,//হাই
                'rubber'                => $this->rubber,
                'additional'            => $this->lower_additional
            ];
            if ($encoded='encode') {
                return json_encode($result);
            }else {
                return $result;
            }
            
        }else{
            return null;
        }   
    }
    // upper design json conversion
    public function lowerDesignsJsonEncode($encoded='encode'){
        if ($this->lo_design_fields!=null && count(array_filter($this->lo_design_fields))>0) {
            $result = [];
            foreach(array_filter($this->lo_design_fields) as $k=> $val){
                $result[$k]=trim($val)!='' ? trim($val):null;
            }
            if ($encoded='encode') {
                return json_encode($result);
            }else {
                return $result;
            }
        }else {
            return null;
        }
        
    }
    public function lowerWagesJsonEncode($encoded=null)
    {
        if (isset($this->lower['total']) && ($this->lo_products != null || $this->lo_products!=0)) {
            $order_discount         = isset($this->lower['discount']) && $this->lower['discount'] && $this->lower['discount'] ? $this->lower['discount'] : 0;
            $order_advance          = isset($this->lower['advance']) &&  $this->lower['advance'] && $this->lower['advance'] ? $this->lower['advance'] : 0;
            $order_total            = $this->lower['total'];
            $calculated             = ['total'=>(int)$order_total, 'discount'=> (int)$order_discount,'advance'=> (int)$order_advance];
            if ($encoded==='encode') {
                return json_encode($calculated);
            }
            return $calculated;
        }else {
            return 0;
        }
    }
     /**
     * LOWER PART END
     */
    //==========================================================================
     /**
     * COMMON PART START
     */
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
        $this->upperWagesesCalculation();
        // pazama pannt, trowser lower dress
        $this->lowerWagesesCalculation();
    }
    
    public function upperWagesesCalculation()
    {
        //panzabi, shart fotual upper dress
        if (isset($this->upper['wages']) && $this->upper['wages'] != null && is_numeric($this->upper['wages']) && isset($this->upper['quantity']) && $this->upper['quantity'] &&  $this->upper['quantity'] != null && is_numeric($this->upper['quantity'])) {
            $this->upper['total'] = $this->upper['quantity'] * $this->upper['wages'] - (isset($this->upper['discount']) && $this->upper['discount'] ? $this->upper['discount']: 0);
        }else {
            $this->upper['total']=0;
        }
    }

    public function lowerWagesesCalculation()
    {
         // pazama pannt, trowser lower dress
        if (isset($this->lower['wages']) && $this->lower['wages'] != null && is_numeric($this->lower['wages']) && isset($this->lower['quantity']) && $this->lower['quantity'] &&  $this->lower['quantity'] != null && is_numeric($this->lower['quantity'])) {
                $this->lower['total'] = $this->lower['quantity'] * $this->lower['wages'] - (isset($this->lower['discount']) && $this->lower['discount'] ? $this->lower['discount']: 0);
        }else {
            $this->lower['total']=0;
        }
    }

    
    

    /**
     * Design field
     */

    public function checkAndValueFieldMatching($checks,$fields)
    {
        // $checks= $this->up_designs_check;
        // $fields = $this->up_design_fields;

        $checkFilter = array_filter($checks);
        if ( count($checkFilter) > 0 ) {
            $filter1 = array_filter($checks);
            $filter2 = array_filter($fields);
            $newArr = [];
            $firstKeyofArr = array_keys($filter1);
            for ($i=0; $i < count($filter1); $i++) {
                if (in_array($firstKeyofArr[$i], array_keys($filter2))) {
                    $newArr[$firstKeyofArr[$i]]=$filter2[$firstKeyofArr[$i]];
                }else {
                    $newArr[$firstKeyofArr[$i]]="  ";
                }
            }
           return $newArr;
           
        }else {
            $this->dispatchBrowserEvent('design_alert', ['message' => "<span>লাল রঙের বক্স গুলো <i class='fa fa-check text-danger'></i> দিন!</span>",]);
        }
    }
   
    public function designChecker($checks, $fields)
    {
            if (count(array_filter($checks)) === 0 && count(array_filter($fields)) === 0) {
                $this->dispatchBrowserEvent('design_alert', ['message' => "কিছু ডিজাইন যুক্ত করুণ <i class='fa fa-exclamation-triangle text-danger'></i>",'effect'=>'warning']);
            }
            else {
                $result =  $this->checkAndValueFieldMatching($checks, $fields);
                if (count($result) !== count(array_filter($checks))) {
                    $this->dispatchBrowserEvent('design_alert', ['message' => "লাল রঙের বক্স গুলো <i class='fa fa-check text-danger'></i> দিন!",'effect'=>'error',]);
                    return false;
                }else{
                    return $result;
                }
            }
            
    }
    public function designResetTrait($arg=null)
    {
        if ($arg!=null && ($arg==='upper' || $arg==='lower')) {
            if ($arg==='upper') {
                $this->upper_design_show=false;
                $this->up_status=null;
                $this->up_designs_check=[];
                $this->up_design_fields=[];
                $this->upper=null;
                
            }elseif ($arg==='lower') {
                $this->lower_design_show=false;
                $this->lo_designs_check=[];
                $this->lo_design_fields=[];
                $this->lower=null;
                $this->lo_status=null;
            }
        }else{
            $this->dispatchBrowserEvent('design_alert', ['message' => "<span class='d-block pt-2'>কি করতে চাচ্ছেন<i class='fa fa-question text-danger'></i></span>",'effect'=>'error']);
        }
    }
    public function order_management_status_change($id)
    {
        $order = OrderManagement::find($id);
        $order->status = "";
    }
    public function changeOrderItemStatusWithOrderManagement($id, $status, $saveItem=null)
    {
        $order                          = OrderItem::find($id);
        $order->status                  = $status;
        if ($saveItem) {
            $order->save();
        }        
        if ( $status && ($status!=='cancled' || $status!=='completed')) {
            $order->itemGroup->status   = $status;
            $order->itemGroup->save();
        }

    }
    
}