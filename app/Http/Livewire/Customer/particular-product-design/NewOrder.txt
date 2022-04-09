<?php
namespace App\Http\Livewire\Customer;
use App\Models\Order;
use App\Models\Product;
use Livewire\Component;
use App\Models\Customer;
use App\Traits\OrderTrait;
use App\Models\DesignGroup;
use App\Models\ClothDesignPortion;

class NewOrder extends Component
{
   use OrderTrait;

    //Customer
    public $customer_id, $name, $email, $mobile;
    //Order
    public $order_number, $delivery_date, $order_date, $force_id, $order_delivery, $force_previous_date, $weekendholiday, $maxOrderId;
    /**
     * Upper part
     * Panzabi
     */
    //Order Item 
    public $up_products=[], $lo_products=[], $cloth_long, $cloth_body, $body_loose, $cloth_belly, $belly_loose, $cloth_enclosure, $hand_long, $sleeve_enclosure, $sleeve_pasting, $cloth_throat, $cloth_collar, $collar_measure_type, $cloth_shoulder, $cloth_mora, $noke_shoho, $designs_check, $design_fields, $cloth_additional, $wages, $quantity, $discount, $advance, $total, $order_sample_images, $plate_type,$pocket_type, $readymade_size;

    /**
     * Lower Part
     * @param around_ankle পায়ের মুহুরী
     * * @param crotch হাই
     * @param waist কোমর
     * @param thigh_loose রান/উরু
     */
    public $length, $around_ankle, $thigh_loose, $waist, $crotch,$rubber, $lower_additional;
    //Order Delivery
    public $delivery_system, $courier_details, $delivery_charge, $country, $city, $province, $zipcode, $line1,$line2;
    /**
     * Design fields
     */
    public $up_designs_check=[], $up_design_fields=[], $lo_designs_check=[], $lo_design_fields=[], $upper_design_show, $lower_design_show, $show_design_group_heading;
    

    public function mount($customer_id)
    {
        $this->customer_id=$customer_id;
        $customer = Customer::findOrFail($customer_id);
        $this->name = $customer->name;
        $this->email = $customer->email;
        $this->mobile = $customer->mobile;
        $lastOrder = Order::orderBy('id',"DESC")->first();
        $this->delivery_date = date( "Y-m-d", strtotime( date( "Y-m-d")." +10 days" ));
        if( $lastOrder== null){
        $this->order_number =1;
        }else{
            $this->order_number = $lastOrder->order_number+1;   
        }
    }
    public function updated($fields)
    {
        
        if (!$this->force_previous_date) {
            $this->validateOnly($fields,[
                'delivery_date'     => 'required|date|date_format:Y-m-d|after:yesterday',
            ]);
        }
        $this->validateOnly($fields,[
            'order_number'      => "required|numeric|unique:orders|min:1|max:".$this->maxOrderNoFixing($this->order_number),
            'delivery_date'     => 'required|date|date_format:Y-m-d',
            'order_date'        => 'nullable|date|date_format:Y-m-d|before_or_equal:delivery_date',
            'up_products'          => 'required|array',
            'lo_products'          => 'required|array',
            // 'order_sample_images.*'=>'image|mimes:jpg,jpeg,png|nullable',
            //Measure
            'cloth_long'            => 'required_with:up_products|numeric|max:80',
            'cloth_body'            => 'nullable|numeric|max:80',
            'body_loose'            => 'nullable|numeric|max:80',
            'cloth_belly'           => 'nullable|numeric|max:80',
            'belly_loose'           => 'nullable|numeric|max:80',
            'cloth_enclosure'       => 'required_with:up_products|numeric|max:80',
            'hand_long'             => 'required_with:up_products|numeric|max:80',
            'sleeve_enclosure'      => 'nullable|numeric|max:80',
            'sleeve_pasting'        => 'nullable|string',
            'cloth_throat'          => 'nullable|numeric|max:80',
            'cloth_collar'          => 'nullable|numeric|max:80',
            'collar_measure_type'   => 'numeric|nullable',
            'cloth_shoulder'        => 'required_with:up_products|numeric|max:80',
            'cloth_mora'            => 'nullable|numeric|max:80',
            'noke_shoho'            => 'nullable|numeric|max:80',
            'plate_type'            => 'required_with:up_products',
            'pocket_type'           => 'required',
            'cloth_additional'      => 'nullable|string',
            //lower part
            'length'                => 'required_with:lo_products|numeric',
            'around_ankle'          => 'required_with:lo_products|numeric',
            'thigh_loose'           => 'required_with:lo_products|numeric',
            'waist'                 => 'required_with:lo_products|numeric',
            'crotch'                => 'required_with:lo_products|numeric',

            'up_designs_check.*'    => 'nullable|numeric',
            'up_design_fields.*'    => 'nullable|numeric',
            'lo_designs_check.*'    => 'nullable|numeric',
            'lo_design_fields.*'    => 'nullable|numeric',
            'wages'                 => 'required|numeric|gt:0',
            'quantity'              => 'gt:0|required|numeric|gt:0',
            'discount'              => 'nullable|numeric|gt:0',
            'advance'               => 'nullable|numeric|gt:0',
            'total'                 => 'required|numeric|gt:0',
        ]);
        
        //order delivery validation
        if ( $this->order_delivery ) {
            $this->validateOnly($fields,[
                'delivery_system'   => 'required|numeric|gt:0',
                'courier_details'   =>  'required',
                'delivery_charge'   =>  'required|numeric',
                'country'           =>  'required',
                'city'              =>  'required',
                'province'          =>  'required',
                'zipcode'           =>  'required',
                'line1'             =>  'required',
            ]);
        }
    }
    /**
     * Fill empty style field
     */
    public function fillEmptyStyleField($style_id){
        // $this->TraitfillEmptyStyleField($style_id);
        $filterArr = array_filter($this->up_design_fields);
        if (in_array($style_id, array_keys($filterArr)) == false) {            
            $this->up_design_fields[$style_id]=' ';
            // $this->up_design_fields[$style_id] = $this->up_design_fields[$style_id];
        }
        // else {
        //     $this->up_design_fields[$style_id]=' ';
        // }
        
    }
    public function addOrder()
    {
        $result  = $this->placeOrder($this->customer_id);
    }
    public function designsShowHideControl()
    {
        $this->upper_design_show=0;
    }
    
    public function groupTitleControl()
    {
        $this->dispatchBrowserEvent('groupTitleShow', ['keyname'=>""]);
    }

    public function render()
    {
        $this->minMaxOrderId();
        $upperProductsPart = Product::where('status',1)->where('type',1)->get();
        $lowerProductsPart = Product::where('status',1)->where('type',2)->get();
        $allproducts = Product::where('status',1)->get();
        $desgnGroups = DesignGroup::get();
        $clothDesignPortion = ClothDesignPortion::where('status',1)->get();
        return view('livewire.customer.new-order', compact('allproducts','upperProductsPart','lowerProductsPart', 'desgnGroups', 'clothDesignPortion'))->layout('layouts.starter');
    }
}
