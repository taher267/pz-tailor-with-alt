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
}


// $table->enum('status', ['processing', 'cancled','completed','urgent','replaced','waiting','alter','notyet','printed','ban'])->default('processing');