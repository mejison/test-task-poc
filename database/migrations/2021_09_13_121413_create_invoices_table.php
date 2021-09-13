<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     *   "id" bigint [pk, not null, increment]
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('order_id')->nullable();
            $table->bigInteger('shipment_id')->nullable();
            $table->bigInteger('company_id')->nullable();
            $table->bigInteger('purchase_order_id')->nullable();
            $table->string('status')->nullable();
            $table->decimal('amount', 8, 2);
            $table->string('currency', 3)->nullable();
            $table->string('terms')->nullable();
            $table->string('attatchment_url')->nullable();
            $table->string('invoice_number')->nullable();
            $table->boolean('auto_generated')->default(false);
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
        Schema::dropIfExists('invoices');
    }
}
