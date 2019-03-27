<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePayoutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // public $fillable = ['character_id', 'item', 'quantity', 'isk'];
        Schema::create('seat_payout_payouts', function (Blueprint $table) {
            $table->integer('user_id');
            $table->string('character_name');
            $table->string('item');
            $table->integer('quantity');
            $table->integer('isk');
            $table->timestamps();
            $table->primary(['user_id', 'character_name']);
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
