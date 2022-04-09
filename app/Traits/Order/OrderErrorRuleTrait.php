<?php
namespace App\Traits\Order;

trait OrderErrorRuleTrait {
    public function forceIdWithDateErrorRule()
    {
        return[
            'delivery_date'     => 'required|date|date_format:Y-m-d|after:yesterday',
        ];
    }
    
    public function orderDeliveryErrorRule()
    {
        return[
            'delivery_system'   => 'required|numeric|gt:0',
            'courier_details'   =>  'required',
            'delivery_charge'   =>  'required|numeric',
            'country'           =>  'required',
            'city'              =>  'required',
            'province'          =>  'required',
            'zipcode'           =>  'required',
            'line1'             =>  'required',
        ];
    }

    public function commonOrderErrorRule()
    {
        return[
            'delivery_date'         => 'required|date|date_format:Y-m-d',
            'order_date'            => 'nullable|date|date_format:Y-m-d|before_or_equal:delivery_date',
            'up_products'          => 'required_without:lo_products|array',
            'lo_products'          => 'required_without:up_products|array',
            'order_sample_images.*'=>'image|mimes:jpg,jpeg,png|nullable',
            //Measure
            'cloth_body'            => 'nullable',
            'body_loose'            => 'nullable',
            'cloth_belly'           => 'nullable',
            'belly_loose'           => 'nullable',
            'sleeve_enclosure'      => 'nullable',
            'sleeve_pasting'        => 'nullable',
            'cloth_throat'          => 'nullable',
            'cloth_collar'          => 'nullable',
            'collar_measure_type'   => 'numeric|nullable',
            'cloth_mora'            => 'nullable',
            'noke_shoho'            => 'nullable',
            'cloth_additional'      => 'nullable|string',
            'pocket_type'           => 'nullable|numeric',
            'up_designs_check.*'    => 'nullable|numeric',
            'up_design_fields.*'    => 'nullable|numeric',
            'lo_designs_check.*'    => 'nullable|numeric',
            'lo_design_fields.*'    => 'nullable|numeric',
            'wages_selected_products'=> 'required|array',
            'wages'                 => 'required|array',
            'quantity'              => 'required|array',
            'discount'              => 'nullable|array',
            'advance'               => 'nullable|array',
            'total'                 => 'required|array',
            'wages_screenshot_url'  => 'required|url'
        ];
    }

    public function upProductsPresentErrorRule()
    {
        return[
            'up_products'          => 'required_without:lo_products|array',
            //Measure
            'cloth_long'            => 'required|string',
            'cloth_enclosure'       => 'required|string',
            'hand_long'             => 'required|string',
            'cloth_shoulder'        => 'required|string',
            'plate_type'            => 'required'
        ];
    }

    public function loProductsPresentErrorRule()
    {
        return[
            'lo_products'          => 'required_without:up_products|array',
            //lower part
            'length'                => 'required|string',
            'around_ankle'          => 'required|string',
            'thigh_loose'           => 'required|string',
            'waist'                 => 'required|string',
            'crotch'                => 'required|string',
        ];
    }
}
          

// return[
//     'delivery_date'         => 'required|date|date_format:Y-m-d',
//     'order_date'            => 'nullable|date|date_format:Y-m-d|before_or_equal:delivery_date',
//     'up_products'          => 'required_without:lo_products|array',
//     'lo_products'          => 'required_without:up_products|array',
//     'order_sample_images.*'=>'image|mimes:jpg,jpeg,png|nullable',
//     //Measure
//     'cloth_long'            => 'required_with:up_products|numeric|max:80',
//     'cloth_body'            => 'nullable|numeric|max:80',
//     'body_loose'            => 'nullable|numeric|max:80',
//     'cloth_belly'           => 'nullable|numeric|max:80',
//     'belly_loose'           => 'nullable|numeric|max:80',
//     'cloth_enclosure'       => 'required_with:up_products|numeric|max:80',
//     'hand_long'             => 'required_with:up_products|numeric|max:80',
//     'sleeve_enclosure'      => 'nullable|numeric|max:80',
//     'sleeve_pasting'        => 'nullable|string',
//     'cloth_throat'          => 'nullable|numeric|max:80',
//     'cloth_collar'          => 'nullable|numeric|max:80',
//     'collar_measure_type'   => 'numeric|nullable',
//     'cloth_shoulder'        => 'required_with:up_products|numeric|max:80',
//     'cloth_mora'            => 'nullable|numeric|max:80',
//     'noke_shoho'            => 'nullable|numeric|max:80',
//     'plate_type'            => 'required_with:up_products',
//     'pocket_type'           => 'required',
//     'cloth_additional'      => 'nullable|string',
//     //lower part
//     'length'                => 'required_with:lo_products|numeric',
//     'around_ankle'          => 'required_with:lo_products|numeric',
//     'thigh_loose'           => 'required_with:lo_products|numeric',
//     'waist'                 => 'required_with:lo_products|numeric',
//     'crotch'                => 'required_with:lo_products|numeric',

//     'up_designs_check.*'    => 'nullable|numeric',
//     'up_design_fields.*'    => 'nullable|numeric',
//     'lo_designs_check.*'    => 'nullable|numeric',
//     'lo_design_fields.*'    => 'nullable|numeric',
//     'wages.*'               => 'required|numeric|gt:0',
//     'quantity.*'            => 'gt:0|required|numeric|gt:0',
//     'discount.*'            => 'nullable|numeric|gt:0',
//     'advance.*'             => 'nullable|numeric|gt:0',
//     'total.*'               => 'required|numeric|gt:0',
// ];