<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->string('type');
            $table->boolean('status')->default(true);
            $table->decimal('wages',5,2)->nullable();
            $table->longText('option')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};

// INSERT INTO `products` (`id`, `name`, `slug`,`type`, `status`) VALUES (1, 'একছাটা', 'একছাটা', 1,1), (2, 'পাঞ্জাবী', 'পাঞ্জাবী',1,1), (3, 'শর্ট পাঞ্জাবী', 'শর্ট পাঞ্জাবী', 1,1), (4, 'পায়জামা', 'পায়জামা',1,1), (5, 'একছাটা জুব্বা', 'একছাটা জুব্বা',1,1), (6, ' কাবলী', ' কাবলী',1,1), (7, 'এরাবিয়ান', 'এরাবিয়ান',1,1), (8, ' গোলজামা', ' গোলজামা',1,1), (9, 'ফতুয়া', 'ফতুয়া',1,1), (10, 'শেরওয়ানী', 'শেরওয়ানী',1,1), (11, 'কটি', 'কটি',1,1), (12, 'সালোয়ার', 'সালোয়ার',1,1), (13, 'চোষ পায়জামা', 'চোষ-পায়জামা',1,1), (14, 'আলিগড়', 'আলিগড়',1,1), (15, ' ধুতি', ' ধুতি',1,1);
