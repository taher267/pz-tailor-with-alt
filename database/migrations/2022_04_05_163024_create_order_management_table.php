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
        Schema::create('order_management', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('customer_id')->unsigned();
            $table->integer('order_number');
            $table->json('wageses');
            $table->json('transaction')->nullable();
            $table->date('delivery_date');
            $table->date('delivered_date')->nullable();
            $table->enum('status', ['processing', 'cancled','completed','urgent','replaced','waiting','alter','notyet','printed','ban'])->default('processing');
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
        Schema::dropIfExists('order_management');
    }
};
