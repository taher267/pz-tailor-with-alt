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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned();
            //$table->bigInteger('customer_id')->unsigned();
            $table->bigInteger('order_management_id')->unsigned();
            $table->foreignId('order_number');
            $table->string('type');
            $table->json('item_summary')->nullable();
            $table->json('measurement')->nullable();
            $table->json('designs')->nullable();
            $table->enum('status', ['processing', 'cancled','completed','urgent','replaced','waiting','alter','notyet','trial','trial-after-process'])->default('processing');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('order_management_id')->references('id')->on('order_management')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_items');
    }
};
