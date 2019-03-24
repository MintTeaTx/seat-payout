<?php
/**
 * Created by PhpStorm.
 * User: bitch
 * Date: 3/24/2019
 * Time: 12:37 AM
 */

namespace Fordav3\Seat\Payout\Http\Controllers;
use Seat\Services\Repositories\Configuration\UserRespository;
use Fordav3\Seat\Payout\Models\Payout;


class PayoutController extends Controller implements CalculateConstants
{
    use UserRepository;

    function getPayoutView()
    {
        $payouts = [];



    }

    function buildPayoutTable($fleetlog)
    {
        $logarray = explode("\n", $fleetlog);
        $payouts = [];

        foreach ($logarray as $entry)
        {

        }
    }
    function buildPayout($entry)
    {
        $regex= '#^\d\d:\d\d:\d\d (?<charname>(\w|\s)+)\shas\slooted\s(?<quantity>(\d|,)+)\sx\s(?<item>(\w|\s)+)$#';
        $payout = new Payout();
        preg_match($regex,$entry,$values);
        $character_id = values['charname'];
        $payout->character_id = Character::with('character_id');
        $payout->item = $values['item'];
        $payout->quantity = $values['quantity'];
    }
    function getItemPrice($item)
    {

    }



}