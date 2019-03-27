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
        return view('payout::payout', compact('payouts'));
    }

    function buildPayoutTable(SavePayout $request)
    {
        $fleetlog = $request->fleetLog;
        $logarray = explode("\n", $fleetlog);
        $payouts = [];

        foreach ($logarray as $entry)
        {
            $payout =$this->buildPayout($entry);
            $payouts[$payout->getKey()];
        }

        return redirect()->back();
    }
    function buildPayout($entry)
    {

        $regex= '#^\d\d:\d\d:\d\d (?<charname>(\w|\s)+)\shas\slooted\s(?<quantity>(\d|,)+)\sx\s(?<item>(\w|\s)+)$#';
        $payout = new Payout;
        preg_match($regex,$entry,$values);
        $character_name = $values['charname'];
        $character = CharacterInfo::where('name', $character_name)->first();
        $user = $this->getUser($character->getKey());
	
        $character = $this->getMainCharacter($character);
        $payout = Payout::updateOrCreate(['user_id' => $user->getKey(), 'item' => $values['item'], 'quantity'=>$values['quantity']]);
        return $payout;
    }
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
