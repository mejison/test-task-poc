<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShipmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shipments', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('order_id')->nullable();
            $table->bigInteger('invoice_id')->nullable();
            $table->string('carrier')->nullable();
            $table->string('tracking')->nullable();
            $table->string('status')->nullable();
            $table->string('carrier_url')->nullable();
            $table->string('notes')->nullable();
            $table->string('bc_status')->nullable();
            $table->string('bol_url')->nullable();
            $table->string('bol_number')->nullable();
            $table->string('shipping_method')->nullable();
            $table->decimal('shipping_cost', 8, 2)->nullable();
            $table->string('currency', 3)->nullable();
            $table->date('expected_at')->nullable();
            $table->date('shipped_at')->nullable();
            $table->date('delivered_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shipments');
    }
}
