<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderManagement extends Model
{
    use HasFactory;
}


// $table->enum('status', ['processing', 'cancled','completed','urgent','replaced','waiting','alter','notyet','printed','ban'])->default('processing');