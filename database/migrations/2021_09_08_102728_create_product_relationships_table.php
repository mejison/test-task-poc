<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductRelationshipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_relationships', function (Blueprint $table) {
            $table->id();
            $table->string('MPN')->nullable();
            $table->string('PrefixNumber')->nullable();
            $table->string('StockNumberButted')->nullable();
            $table->json('Relationship')->nullable();
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
        Schema::dropIfExists('product_relationships');
    }
}
