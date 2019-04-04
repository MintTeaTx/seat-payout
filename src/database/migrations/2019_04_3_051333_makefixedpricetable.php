<?php
/**
 * Created by PhpStorm.
 * User: bitch
 * Date: 4/3/2019
 * Time: 9:16 PM
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;


class Makefixedpricetable extends Migration
{
    public function up()
    {
        Schema::create('seat_payout_fixed_payouts', function (Blueprint $table) {
            $table->string('item')->unique();
            $table->integer('isk');
            $table->primary('item');
        });
    }

    public function down()
    {
        Schema::dropIfExists('seat_payout_fixed_payouts');
    }
}