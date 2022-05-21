<?php

namespace App\Http\Livewire\Customer;

use App\Models\Product;
use Livewire\Component;
use App\Models\OrderItem;
use App\Models\DesignItem;
use App\Models\DesignGroup;
use App\Models\OrderManagement;
use App\Traits\Order\OrderTrait;
use Illuminate\Routing\UrlGenerator;
use App\Traits\Order\OrderErrorRuleTrait;

class CustomerUpperClothItemEdit extends Component
{
    use OrderTrait;
    use OrderErrorRuleTrait;
    public $prev_url=null;
    public $order_number, $order_management_id, $item_id, $item_group;
    public $up_products, $up_status, $prev_qty;
    //Measurement
    public $cloth_long, $cloth_body, $body_loose, $cloth_belly, $belly_loose, $cloth_enclosure, $hand_long, $sleeve_enclosure, $cloth_mora, $sleeve_pasting, $cloth_throat, $cloth_collar, $cloth_shoulder, $noke_shoho, $cloth_additional, $pocket=[],$plate=[], $plate_length, $upper, $order_sample_images;
    public $upper_design_show, $up_designs_check=[], $up_design_fields=[], $collar_measure_type;
    public function mount($item_id)
    {
        $item = OrderItem::where('id',$item_id)->where('type', 'upper')->firstOrFail();
        $this->item_group           = $item->itemGroup;
        $this->item_id              = $item_id;
        $this->order_number         = $item->order_number;
        $this->order_management_id  = $item->order_management_id;
        $this->up_status            = $item->status;    
        $measurement                = json_decode($item->measurement);
        $this->up_products          = $measurement->product;
        $this->cloth_long           = $measurement->cloth_long;
        $this->cloth_body           = $measurement->cloth_body;
        $this->body_loose           = $measurement->body_loose;
        $this->cloth_belly          = $measurement->cloth_belly;
        $this->belly_loose          = $measurement->belly_loose;
        $this->cloth_enclosure      = $measurement->cloth_enclosure;
        $this->hand_long            = $measurement->hand_long;
        $this->sleeve_enclosure     = $measurement->sleeve_enclosure;
        $this->cloth_mora           = $measurement->cloth_mora;
        $this->sleeve_pasting       = $measurement->sleeve_pasting;
        $this->cloth_throat         = $measurement->cloth_throat;
        $this->cloth_collar         = $measurement->cloth_collar;
        $this->cloth_additional     = $measurement->cloth_additional;
        $this->cloth_shoulder       = $measurement->cloth_shoulder;
        $this->plate_length       = isset($measurement->plate_length)&& $measurement->plate_length?$measurement->plate_length:null;

        $this->plate['flat']        = isset($measurement->plate->flat)?$measurement->plate->flat:null;
        $this->plate['flat_field']  = isset($measurement->plate->flat_field)?$measurement->plate->flat_field:null;
        $this->plate['angle']        = isset($measurement->plate->angle)?$measurement->plate->angle:null;
        $this->plate['angle_field']  = isset($measurement->plate->angle_field)?$measurement->plate->angle_field:null;
        
        $this->pocket['flat']        = isset($measurement->pocket->flat)?$measurement->pocket->flat:null;
        $this->pocket['flat_field']  = isset($measurement->pocket->flat_field)?$measurement->pocket->flat_field:null;
        $this->pocket['angle']        = isset($measurement->pocket->angle)?$measurement->pocket->angle:null;
        $this->pocket['angle_field']  = isset($measurement->pocket->angle_field)?$measurement->pocket->angle_field:null;   
        // //Design
        $this->upper_design_show=1;
        $designs = json_decode($item->designs);
        foreach ($designs as $key => $design) {
            $this->up_designs_check[$key]=$key;
            if ($design) {
                $this->up_design_fields[$key]=$design;
            }
        }

        $summary                    = json_decode($item->item_summary);
        // dd($summary);
        $this->upper['quantity']    = $summary->quantity;
        $this->prev_qty             = $summary->quantity;
        $this->upper['wages']       = ($summary->wages->total+$summary->wages->discount)/$summary->quantity;
        $this->upper['discount']    = $summary->wages->discount;
        $this->upper['advance']     = $summary->wages->advance;
        $this->upper['total']       = $summary->wages->total;
    }
    public function updated($fields)
    {
        $this->validateOnly($fields,$this->upProductsPresentErrorRule());
    }

    public function resetDesignFields($params)
    {
        $this->designResetTrait($params);
    }
    public function upperFillEmptyStyleField($style_id){
        // $filterArr = array_filter($this->up_design_fields);
        // if (in_array($style_id, array_keys($filterArr)) == false) {            
        //     $this->up_design_fields[$style_id]=' ';
        // } 
    }

    public function updateOrderItem($url)
    {
        $this->prev_url=$url;
        $this->validate($this->upProductsPresentErrorRule());
        // if (count(array_filter($this->up_designs_check))==0) {
        //     return  $this->dispatchBrowserEvent('design_alert', ['message' => "<i class='fa-solid fa-person-dress text-info fa-2x'></i> ডিজাইন যুক্ত করুণ <i class='fa fa-exclamation-triangle text-danger'></i>",'effect'=>'warning']);
        // }
        $result = $this->placeOrderItem($this->order_management_id, $this->item_id);
        Session()->flash('success', "সঠিকভাবে আপডেট হয়েছে");
        return redirect($this->prev_url);
    }
    public function render()
    {
        $this->upperWagesesCalculation();
        $upperProductsPart  = Product::where('status',1)->where('type',1)->get();
        $allproducts        = Product::where('status',1)->get();
        $desgnGroups        = DesignGroup::get();
        $designItems        = DesignItem::where('status',1)->get();
        $statuses           = OrderManagement::orderManagementStatus();
        return view('livewire.customer.customer-upper-cloth-item-edit', compact('upperProductsPart', 'allproducts', 'desgnGroups', 'designItems', 'statuses'))->layout('layouts.starter');
    }
}
