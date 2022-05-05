<?php

namespace App\Http\Livewire\Customer;

use App\Models\Product;
use Livewire\Component;
use App\Models\OrderItem;
use App\Models\DesignItem;
use App\Models\DesignGroup;
use App\Models\OrderManagement;
use App\Traits\Order\OrderTrait;
use App\Traits\Order\OrderErrorRuleTrait;

class CustomerLowerClothItemEdit extends Component
{
    use OrderTrait;
    use OrderErrorRuleTrait;

    public $order_number, $order_management_id, $item_id, $item_group;
    public $lo_products, $length, $around_ankle, $crotch, $lo_status, $waist, $thigh_loose, $rubber, $lower_additional, $lower, $order_sample_images, $prev_qty;
    // Design
    public $lower_design_show, $lo_designs_check=[],$lo_design_fields=[];
    public function mount($order_number, $order_management_id, $item_id)
    {
        // dd(gettype($this->lo_design_fields));
        $item = OrderItem::findOrFail($item_id);
        $this->item_group           = $item->itemGroup;
        $this->item_id              = $item_id;
        $this->order_number         = $order_number;
        $this->order_management_id  = $order_management_id;
        $this->lo_status            = $item->lo_status;
        // dd($item);
        $measurement                = json_decode($item->measurement);
        $this->lo_products          = $measurement->product;
        $this->length               = $measurement->length;
        $this->around_ankle         = $measurement->around_ankle;
        $this->crotch               = $measurement->crotch;
        $this->waist                = $measurement->waist;
        $this->thigh_loose          = $measurement->thigh_loose;
        $this->rubber               = $measurement->rubber;
        
        $this->lower_additional     = isset($measurement->additional)?$measurement->additional:null;
        //Design
        $this->lower_design_show=1;
        $designs = json_decode($item->designs);
        foreach ($designs as $key => $design) {
            $this->lo_designs_check[$key]=$key;
            if ($design) {
                $this->lo_design_fields[$key]=$design;
            }
        }

        $summary                    = json_decode($item->item_summary);
        $this->lower['quantity']    = $summary->quantity;
        $this->prev_qty             = $summary->quantity;
        $this->lower['wages']       = ($summary->wages->total+$summary->wages->discount)/$summary->quantity;
        $this->lower['discount']    = $summary->wages->discount;
        $this->lower['advance']     = $summary->wages->advance;
        $this->lower['total']       = $summary->wages->total;
    }
    public function updated($fields)
    {
        $this->validateOnly($fields,[
            'lo_products'          => 'not_in:0'
        ]);
        if ($this->order_management_id !=null ) {
            // $this->orderAndDeliveryDate();
        }
        $this->validateOnly($fields,$this->loProductsPresentErrorRule());
    }
    public function lowerFillEmptyStyleField($style_id){
        $filterArr = array_filter($this->lo_design_fields);
        if (in_array($style_id, array_keys($filterArr)) == false) {            
            $this->lo_design_fields[$style_id]=' ';
        } 
    }
    public function resetDesignFields($params=null)
    {
        $this->designResetTrait($params);
    }

    public function updateOrderItem()
    {
        // $this->updateOrderSummary();
        $this->validate([
            'lo_products'          => 'not_in:0'
        ]);
        $this->validate($this->loProductsPresentErrorRule());
        if (count(array_filter($this->lo_designs_check))==0) {
            return  $this->dispatchBrowserEvent('design_alert', ['message' => "<i class='fa-solid fa-person-dress text-info fa-2x'></i> ডিজাইন যুক্ত করুণ <i class='fa fa-exclamation-triangle text-danger'></i>",'effect'=>'warning']);
        }
        $result = $this->placeOrderItem($this->order_management_id, $this->item_id);
        // $this->dispatchBrowserEvent('design_alert', ['message' => "সঠিকভাবে আপডেট হয়েছে",'effect'=>'success']);
        Session()->flash('success', "সঠিকভাবে আপডেট হয়েছে");
        return redirect()->route('customer.order.items',[$this->order_number, $this->order_management_id]);
    }
    public function render()
    {
        $this->lowerWagesesCalculation();
        $lowerProductsPart  = Product::where('status', 1)->where('type', 2)->get();
        $designItems        = DesignItem::where('status',1)->get();
        $desgnGroups        = DesignGroup::get();
        $statuses           = OrderManagement::orderManagementStatus();
        return view('livewire.customer.customer-lower-cloth-item-edit', compact('lowerProductsPart', 'designItems', 'desgnGroups', 'statuses'))->layout('layouts.starter');
    }
}
