<?php
namespace Fordav3\Seat\Payout\Http\Controllers;
use Fordav3\Seat\Payout\Validation\SavePayout;
use Illuminate\Http\Request;
//use Illuminate\Database\Eloquent\Models;
use Seat\Services\Repositories\Configuration\UserRespository as UserRepository;
use Seat\Web\Models\Group;
use Seat\Web\Http\Controllers\Controller;
use Fordav3\Seat\Payout\Models\Payout;
use Seat\Eveapi\Models\Character\CharacterInfo;
use Seat\Services\Repositories\Character\Info;

class PayoutController extends Controller
{
    use UserRepository;

    function getPayoutView()
    {
        $payouts = [];

        Payout::truncate();
        return view('payout::payout', compact('payouts'));
    }

    function buildPayoutTable(SavePayout $request)
    {
        Payout::truncate();
        $fleetlog = $request->fleetLog;
        $logarray = explode("\n", $fleetlog);
        $payouts = [];

        foreach ($logarray as $entry)
        {
            $payout =$this->buildPayout($entry);
            $payouts = Payout::all();
        }

        return view('payout::payout', compact('payouts'));
    }
    function buildPayout($entry)
    {

        $regex= '#^\d\d:\d\d:\d\d (?<charname>(\w|\s)+)\shas\slooted\s(?<quantity>(\d|,)+)\sx\s(?<item>(\w|\s)+)$#';
        //$payout = new Payout;
        preg_match($regex,$entry,$values);
        $character_name = $values['charname'];
        $character = CharacterInfo::where('name', $character_name)->first();
        $quantity = number_format(floatval($values['quantity']));

        $character = $this->getMainCharacter($character);


        if(Payout::where('character_name', $character->name)->where('item', $values['item'])->exists())
        {
            $payout = Payout::where('character_name', $character->name)->where('item', $values['item'])->first();
            $payout->quantity = $payout->quantity + $quantity;
            $payout->save();
            return $payout;
        }
        $payout = Payout::updateOrCreate(['character_name' => (string)$character->name, 'item' => $values['item'], 'quantity'=>$quantity]);
        return $payout;
    }
    //TODO: Remove dummy number and implement market data
    function getItemPrice($item)
    {
        return 150;
    }
    function getMainCharacter($character)
    {
            $user = $this->getUser($character->getKey());
            $group = $user->group;
            $main_ID = $group->main_character_id;
            return CharacterInfo::where('character_id', $main_ID)->first();
    }



}
