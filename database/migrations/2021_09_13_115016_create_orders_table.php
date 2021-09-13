<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
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
            $table->string('status')->nullable();
            $table->string('order_number')->nullable();
            $table->string('total_amount')->nullable();
            $table->boolean('csr_high_order_approved')->nullable();
            $table->integer('purchase_orders_total')->nullable();
            $table->integer('purchase_orders_accepted')->nullable();
            $table->integer('purchase_orders_pending')->nullable();
            $table->integer('purchase_orders_rejected')->nullable();
            $table->integer('purchase_orders_backordered')->nullable();
            $table->string('purchase_orders_shipped')->nullable();
            $table->string('purchase_orders_invoiced')->nullable();
            $table->string('purchase_orders_late')->nullable();
            $table->string('bc_order_number')->nullable();
            $table->string('bc_transaction_id')->nullable();
            $table->string('gateway_transaction_id')->nullable();
            $table->string('flag')->nullable();
            $table->bigInteger('user_id')->nullable();
            $table->string('sales_channel')->nullable();
            $table->bigInteger('bc_order_id')->nullable();
            $table->bigInteger('ns_purchase_order_id')->nullable();
            $table->bigInteger('invoice_id')->nullable();
            $table->bigInteger('shipment_id')->nullable();
            $table->bigInteger('company_id')->nullable();
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
        Schema::dropIfExists('orders');
    }
}
