<?php
namespace App\Http\Livewire\Customer;
use App\Models\Product;
use Livewire\Component;
use App\Models\Customer;
use App\Models\DesignItem;
use App\Models\DesignGroup;
use Livewire\WithFileUploads;
use App\Models\OrderManagement;
use App\Traits\Order\OrderTrait;
use App\Traits\Order\OrderErrorRuleTrait;

class NewOrder extends Component
{
   use OrderTrait;
   use OrderErrorRuleTrait;
   use WithFileUploads;

    //Customer
    public $customer_id, $name, $email, $mobile, $photo;
    //Order
    public $order_number, $delivery_date, $order_date, $force_id, $order_delivery, $force_previous_date, $weekendholiday;
    /**
     * Upper part
     * Panzabi
     */
    //Order Item 
    public $up_products, $upper,$lower, $lo_products, $cloth_long, $cloth_body, $body_loose, $cloth_belly, $belly_loose, $cloth_enclosure, $hand_long, $sleeve_enclosure, $sleeve_pasting, $cloth_throat, $cloth_collar, $collar_measure_type, $cloth_shoulder, $cloth_mora, $noke_shoho, $designs_check, $design_fields, $cloth_additional,  $order_sample_images, $plate, $pocket, $readymade_size, $delivery_charge;
    /**
     * wageses
     */
    
    public $wages_selected_products=[], $wages = [], $quantity=[], $discount=[], $advance=[], $total=[], $wages_inputs=[0=>1], $inputItem=1;
    /**
     * Lower Part
     * @param around_ankle পায়ের মুহুরী
     * * @param crotch হাই
     * @param waist কোমর
     * @param thigh_loose রান/উরু
     */
    public $length, $around_ankle, $thigh_loose, $waist, $crotch,$rubber, $lower_additional;
    
    /**
     * Design fields
     */
    public $up_designs_check=[], $up_design_fields=[], $lo_designs_check=[], $lo_design_fields=[], $upper_design_show, $lower_design_show, $show_design_group_heading, $wages_screenshot_url;
    

    public function mount($order_number)
    {
        $this->order_number =$order_number;
        $customer           = Customer::findOrFail($order_number);
        $this->customer_id  = $customer->id;
        $this->name         = $customer->name;
        $this->email        = $customer->email;
        $this->mobile       = $customer->mobile;
        $this->photo        = $customer->photo;
        $this->delivery_date = date( "Y-m-d", strtotime( date( "Y-m-d")." +10 days" ));
        $this->weekendholiday = 4;
        
    }
    public function updated($fields)
    {
        
        // if (!$this->force_previous_date) {
        //     $this->validateOnly($fields,$this->forceIdWithDateErrorRule());
        // }
        $this->validateOnly($fields,$this->commonOrderErrorRule());
        // //order delivery validation
        // if ( $this->order_delivery ) {
        //     $this->validateOnly($fields,$this->orderDeliveryErrorRule());
        // }

        // if ( $this->up_products>0) {
        //     $this->validateOnly($fields,$this->upProductsPresentErrorRule());
        // }
        // if ( $this->up_products>0) {
        //     $this->validateOnly($fields,$this->loProductsPresentErrorRule());
        // }
    }
    /**
     * Fill empty style field
     */
    public function upperFillEmptyStyleField($style_id){
        $filterArr = array_filter($this->up_design_fields);
        if (in_array($style_id, array_keys($filterArr)) == false) {            
            $this->up_design_fields[$style_id]=' ';
        } 
    }

    public function lowerFillEmptyStyleField($style_id){
        $filterArr = array_filter($this->lo_design_fields);
        if (in_array($style_id, array_keys($filterArr)) == false) {            
            $this->lo_design_fields[$style_id]=' ';
        } 
    }

    public function addOrder()
    {
        $this->validate($this->commonOrderErrorRule());
        dd(array_filter($this->plate));
        // $result  = $this->placeOrder($this->customer_id);
    }
    public function designsShowHideControl()
    {
        $this->upper_design_show=0;
    }
    
    public function groupTitleControl()
    {
        $this->dispatchBrowserEvent('groupTitleShow', ['keyname'=>""]);
    }

    /**
     * weekend enable and desabla
     */
    public function weekEndEnableAndDisable()
    {
        // $this->dispatchBrowserEvent('force_previous_date', ['data'=>$this->force_previous_date]);
    }
    public function add($i)
    {
        $counts = count($this->up_products)+count($this->lo_products);
        if ($counts <= count($this->wages_inputs)) {
            return;
        }
        array_push($this->wages_inputs,$i++);
    }
    public function remove($i)
    {
        // if (count($this->wages_inputs)<2) {
        //     return;
        // }
        // unset($this->wages_inputs[$i]);
        // unset($this->wages[$i]);
        // unset($this->total[$i]);
        // unset($this->quantity[$i]);
        // unset($this->discount[$i]);
        // unset($this->advance[$i]);
    }
    public function render()
    {
        $this->wagesesCalculation();
        $upperProductsPart = Product::where('status',1)->where('type',1)->get();
        $lowerProductsPart = Product::where('status',1)->where('type',2)->get();
        $allproducts = Product::where('status',1)->get();
        $desgnGroups = DesignGroup::get();
        $designItems = DesignItem::where('status',1)->get();
        return view('livewire.customer.new-order', compact('allproducts','upperProductsPart','lowerProductsPart', 'desgnGroups', 'designItems'))->layout('layouts.starter');
    }
}
