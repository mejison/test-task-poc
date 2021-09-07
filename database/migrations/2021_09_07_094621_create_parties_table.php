<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePartiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parties', function (Blueprint $table) {
            $table->id();
            $table->json('PartyIDs')->nullable();
            $table->string('Name')->nullable();
            $table->json('ChildParty')->nullable();
            $table->json('PartnerRoleCodes')->nullable();
            $table->string('VendorShortName')->nullable();
            $table->string('VendorAbbreviation')->nullable();
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
        Schema::dropIfExists('parties');
    }
}
