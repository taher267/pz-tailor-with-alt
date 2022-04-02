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
        Schema::create('orders', function (Blueprint $table) {
                $table->id();
                $table->bigInteger('user_id')->unsigned();
                $table->bigInteger('customer_id')->unsigned();
                $table->integer('order_number')->unique();
                $table->json('wages');
                $table->json('courier_details')->nullable();
                $table->json('payment_details')->nullable();
                $table->date('delivery_date');
                $table->date('delivered_date')->nullable();
                $table->enum('status', ['processing', 'cancled','completed','urgent','replaced','waiting','alter'])->nullable()->default('processing');
                $table->json('order_sample_images')->nullable();
                $table->timestamps();
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
                $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
