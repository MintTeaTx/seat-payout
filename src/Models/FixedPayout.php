<?php
/**
 * Created by PhpStorm.
 * User: bitch
 * Date: 4/3/2019
 * Time: 5:43 PM
 */

namespace Fordav3\Seat\Payout\Models;


use Illuminate\Database\Eloquent\Model;

class FixedPayout extends Model
{
    protected $table = 'seat_payout_fixed_payouts';

    public $incrementing = false;
    public $timestamps = false;
    public $primaryKey = 'item';

    public $fillable = ['item', 'isk'];
}