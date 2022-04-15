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
            'delivery_date'        => 'required|date|date_format:Y-m-d',
            'order_date'           => 'required|date|date_format:Y-m-d|before_or_equal:delivery_date',
            'up_products'          => 'required_without:lo_products',
            'lo_products'          => 'required_without:up_products',
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
            'cloth_enclosure'       => 'nullable|string',
            'collar_measure_type'   => 'numeric|nullable',
            'cloth_mora'            => 'nullable',
            'noke_shoho'            => 'nullable',
            'cloth_additional'      => 'nullable|string',
            'plate'                 => 'nullable',
            'pocket'                => 'nullable',
            // 'up_designs_check.*'    => 'nullable',
            // 'up_design_fields.*'    => 'nullable',
            // 'lo_designs_check.*'    => 'nullable',
            // 'lo_design_fields.*'    => 'nullable',
            // 'wages'                 => 'required',
            // 'quantity'                 => 'required',
            // 'discount.*'              => 'nullable|array',
            // 'advance.*'               => 'nullable|array',
            // 'total.*'                 => 'required|array'
        ];
    }

    public function upProductsPresentErrorRule()
    {
        return[
            'up_products'          => 'required_without:lo_products|not_in:0',
            //Measure
            'cloth_long'            => 'required|string',
            'hand_long'             => 'required|string',
            'cloth_shoulder'        => 'required|string',
            'upper.quantity'        => 'required|numeric',
            'upper.wages'           => 'required|numeric',
            'upper.discount'        => 'nullable|numeric',
            'upper.advance'         => 'nullable|numeric',
            'upper.wages'           => 'required|numeric',
            'upper.total'           => 'required|numeric'
        ];
    }

    public function loProductsPresentErrorRule()
    {
        return[
            'lo_products'          => 'required_without:up_products',
            //lower part
            'length'                => 'required|string',
            'around_ankle'          => 'required|string',
            'thigh_loose'           => 'required|string',
            'waist'                 => 'required|string',
            'crotch'                => 'required|string',
            'lower.quantity'        => 'required|numeric',
            'lower.wages'           => 'required|numeric',
            'lower.discount'        => 'nullable|numeric',
            'lower.advance'         => 'nullable|numeric',
            'lower.wages'           => 'required|numeric',
            'lower.total'           => 'required|numeric'
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
//     'pocket'           => 'required',
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