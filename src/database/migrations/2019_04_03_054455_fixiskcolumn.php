<?php
/**
 * Created by PhpStorm.
 * User: bitch
 * Date: 4/3/2019
 * Time: 10:34 PM
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
class Fixiskcolumn extends Migration{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('seat_payout_fixed_payouts', function (Blueprint $table)
        {
            $table->dropColumn('isk');
            $table->integer('isk')->unsigned();

        }

        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('seat_payout_fixed_payouts');

    }
}