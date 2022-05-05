<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderManagement extends Model
{
    use HasFactory;
    /**
     * Get the customer that owns the OrderManagement
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Get all of the orderItems for the OrderManagement
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
    static public function orderManagementStatus()
    {
        return['processing'=>'প্রসেসিং', 'cancled'=>'বাতিল','completed'=>'কমপ্লিট','urgent'=>'আর্জেন্ট','replaced'=>'পরিবর্তন','waiting'=>'ওয়েটিং','alter'=>'অল্টার','notyet'=>'এখনো পদক্ষেপ নেয়া হয়নি','trial'=>'ট্রায়াল','trial-after-process'=>'ট্রিয়ালের পরবর্তী প্রসেস','reclaim'=>'সংশোধন'
        ];
    }
}