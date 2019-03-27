<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Fixpayouttabletwo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
	Schema::dropIfExists('seat_payout_payouts');
	Schema::create('seat_payout_payouts', function (Blueprint $table) {
            $table->integer('user_id');
            $table->string('item');
            $table->integer('quantity');
            $table->timestamps();
            $table->primary('user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('seat_payout_payouts');

    }
}
