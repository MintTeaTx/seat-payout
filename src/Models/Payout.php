<?php
/**
 * Created by PhpStorm.
 * User: bitch
 * Date: 3/24/2019
 * Time: 12:38 AM
 */

namespace Fordav3\Seat\Models;

use Illuminate\Database\Eloquent\Model;


class Payout extends Model
{
    public $fillable = ['character_id', 'item', 'quantity', 'isk'];

}