<?php
namespace App\Http\Livewire\Customer;
use Carbon\Carbon;
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
    public $order_number, $delivery_date, $order_date, $up_status, $lo_status, $delivery_status='processing', $force_id, $order_delivery, $force_previous_date, $weekendholiday, $order_management_id;
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
    public $length, $around_ankle, $thigh_loose, $waist, $crotch, $rubber, $lower_additional;
    
    /**
     * Design fields
     */
    public $up_designs_check=[], $up_design_fields=[], $lo_designs_check=[], $lo_design_fields=[], $upper_design_show, $lower_design_show, $show_design_group_heading, $wages_screenshot_url;
    

    public function mount($order_number, $order_management_id=null)
    {
        $this->order_number = $order_number;
        $customer           = Customer::where('order_number',$order_number)->first();
        if(!$customer){
            // return Customer::findOrFail($order_number);
            // return redirect()->route('welcome');
            // return view('welcome');
        }
        $this->customer_id  = $customer->id;
        $this->name         = $customer->name;
        $this->email        = $customer->email;
        $this->mobile       = $customer->mobile;
        $this->photo        = $customer->photo;
        if ($order_management_id) {
            $this->order_management_id = $order_management_id;
        }else {
            $this->delivery_date = date( "Y-m-d", strtotime( date( "Y-m-d")." +10 days" ));
            $this->weekendholiday = 4;
            $this->order_date = Carbon::now()->format('Y-m-d');
        }
        
    }
    public function updated($fields)
    {
        if ($this->order_management_id !=null ) {
            $this->orderAndDeliveryDate();
        }
        // if (!$this->force_previous_date) {
        //     $this->validateOnly($fields,$this->forceIdWithDateErrorRule());
        // }
        $this->validateOnly($fields,$this->commonOrderErrorRule());
        if ($this->up_products !== null && $this->lo_products ==null) {
            $this->validateOnly($fields,[
                'up_products'          => 'not_in:0'
            ]);
        }
        if ($this->lo_products !==null && $this->up_products == null) {
            $this->validateOnly($fields,[
                'lo_products'          => 'not_in:0',
            ]);
        }
        
        // //order delivery validation
        // if ( $this->order_delivery ) {
        //     $this->validateOnly($fields,$this->orderDeliveryErrorRule());
        // }

        if ($this->up_products) {
            $this->validateOnly($fields,$this->upProductsPresentErrorRule());
        }
        if ($this->lo_products) {
            $this->validateOnly($fields,$this->loProductsPresentErrorRule());
        }
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
        // $this->dispatchBrowserEvent('reset_form', ['data'=>'']);
        $this->validate($this->commonOrderErrorRule());
        if ($this->up_products !== null && $this->lo_products ==null) {
            $this->validate([
                'up_products'          => 'not_in:0'
            ]);
        }
        if ($this->lo_products !==null && $this->up_products == null) {
            $this->validate([
                'lo_products'          => 'not_in:0',
            ]);
        }
        if ($this->up_products) {
            $this->validate($this->upProductsPresentErrorRule());
            if (count($this->up_designs_check)==0) {
                return  $this->dispatchBrowserEvent('design_alert', ['message' => "<i class='fa-solid fa-person-dress text-info fa-2x'></i> ডিজাইন যুক্ত করুণ <i class='fa fa-exclamation-triangle text-danger'></i>",'effect'=>'warning']);
            }
        }

        if ($this->lo_products) {
            $this->validate($this->loProductsPresentErrorRule());
            if (count($this->lo_designs_check)==0) {
                return  $this->dispatchBrowserEvent('design_alert', ['message' => "<i class='fa-solid fa-person-dress text-info fa-2x'></i> ডিজাইন যুক্ত করুণ <i class='fa fa-exclamation-triangle text-danger'></i>",'effect'=>'warning']);
            }
        }
        if($this->up_products){
            $result1 = $this->designChecker($this->up_designs_check,$this->up_design_fields);
            $this->up_design_fields=$result1;
        }
        
        if($this->lo_products){
            $result2 = $this->designChecker($this->lo_designs_check,$this->lo_design_fields);
            $this->up_design_fields=$result2;
        }
        
        $returnAdded = $this->placeOrder($this->customer_id);
        if ($returnAdded === 'new-order-failed') {
            return $this->dispatchBrowserEvent('design_alert', ['message' =>"<span class='d-block pt-2'>অর্ডার যুক্ত হয়নি <i class='fa fa-question text-danger'></i></span>",'effect'=>'error']);
        }elseif ($returnAdded>0) {
            return $this->dispatchBrowserEvent('design_alert', ['message' =>"<span class='d-block pt-2'>অর্ডার যুক্ত যুক্ত হয়েছে</span>",'effect'=>'success']);
        }else {
            return $this->dispatchBrowserEvent('design_alert', ['message' =>"<span class='d-block pt-2'>কিছু ভুল হচ্ছে<i class='fa-brands fa-500px'></i>00</span>",'effect'=>'error']);
        }
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
        // $this->dispatchBrowserEvent('reset_form', ['data'=>$this->force_previous_date]);
    }
    public function add($i)
    {
        $counts = count($this->up_products)+count($this->lo_products);
        if ($counts <= count($this->wages_inputs)) {
            return;
        }
        array_push($this->wages_inputs,$i++);
    }
    
    public function resetDesignFields($arg=null)
    {
        $this->designResetTrait($arg);
    }
    public function render()
    {
        $this->wagesesCalculation();
        
        $upperProductsPart  = Product::where('status',1)->where('type',1)->get();
        $lowerProductsPart  = Product::where('status',1)->where('type',2)->get();
        $allproducts        = Product::where('status',1)->get();
        $desgnGroups        = DesignGroup::get();
        $designItems        = DesignItem::where('status',1)->get();
        $statuses           = OrderManagement::orderManagementStatus();
        return view('livewire.customer.new-order', compact('allproducts','upperProductsPart','lowerProductsPart', 'desgnGroups', 'designItems', 'statuses'))->layout('layouts.starter');
    }
}
