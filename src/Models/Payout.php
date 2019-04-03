<?php
/**
 * Created by PhpStorm.
 * User: bitch
 * Date: 3/24/2019
 * Time: 12:38 AM
 */

namespace Fordav3\Seat\Payout\Models;

use Illuminate\Database\Eloquent\Model;

class Payout extends Model
{
    protected $table = 'seat_payout_payouts';

    public $incrementing = false;

    public $primaryKey = 'character_name';

    public $fillable = ['character_name','item', 'quantity', 'isk'];



}
