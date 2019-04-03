<?php

namespace Fordav3\Seat\Payout\Http\Controllers;
use Fordav3\Seat\Payout\Validation\SavePayout;
use Illuminate\Http\Request;
//use Illuminate\Database\Eloquent\Models;
use Seat\Eveapi\Models\Sde\InvType;
use Seat\Services\Repositories\Configuration\UserRespository as UserRepository;
use Seat\Services\Repositories\Eve\EvePrices;
use Seat\Web\Models\Group;
use Seat\Web\Http\Controllers\Controller;
use Fordav3\Seat\Payout\Models\Payout;
use Seat\Eveapi\Models\Character\CharacterInfo;
use Seat\Services\Repositories\Character\Info;

class PayoutController extends Controller {
    use UserRepository, EvePrices;

    function getPayoutView() {
        $payouts = [];
        $haulerarray = [];
        Payout::truncate();
        return view('payout::payout', compact('payouts', 'haulerarray'));
    }

    function buildPayoutTable(SavePayout $request) {
        Payout::truncate();
        $fleetlog = $request->fleetLog;
        $haulers = $request->haulerList;
        $logarray = explode("\n", $fleetlog);
        $haulerarray = explode("\n", $haulers);
       // $payouts = [];
        foreach ( $logarray as $entry ) {
            $build = $this->buildPayout( $entry , $haulerarray);
            /*if(is_null($build))
            {
                break;
            }
            if ( is_object( $build ) ) {
                 $payout = array(
                     'character_name' => $build->character_name,
                     'item' => $build->item,
                     'quantity' => $build->quantity,

                 );
                 $payouts[ $build->character_name ][ $build->item ] = array(
                    'quantity' => $build->quantity,
                    'isk' => ( $build->quantity * $this->getItemPrice( $build->item )->average_price )
               );
            }*/
        }
        $payouts = Payout::all();
        return view('payout::payout', compact('payouts', 'haulerarray'));
    }

    function buildPayout( $entry , $haulers)
    {
        $formats = array(
            'window' => '#^(?<stamp>[\d:]*)?\s(?<charname>.*?)has looted\s(?<quantity>\d*)\sx\s(?<item>.*?)$#',
            'file' => '#^(?<stamp>[\d:.\s]*)?\t(?<charname>.*?)\t(?<item>.*?)\t(?<quantity>\d*)\t.*?$#'
        );
        foreach ($formats as $type => $regex) {
            preg_match($regex, $entry, $values);
            if (
                !empty($values)
                && array_key_exists('charname', $values)
                && array_key_exists('quantity', $values)
                && array_key_exists('item', $values)
            ) {
                $item = preg_replace("/\r|\n/", "", $values['item']);
               // if($item!='Blue Ice'):return;
               // endif;
                $character_name = $values['charname'];
                logger()->debug($character_name);
                if($character = CharacterInfo::where('name', $character_name)->first()) :
                $quantity = number_format(floatval($values['quantity']));
                 $character = $this->getMainCharacter($character);
                 $isk = $this->getItemPrice($item)->average_price * $quantity;
                     if (Payout::where([['character_name', $character->name], ['item', $item]])->exists()) {
                         logger()->debug($character_name.'\'s payout exists, getting and setting the payout.  '.$character->name.' looted '.$quantity.' of '.$item.' for '.$isk);
                         $payout = Payout::where('character_name', $character->name)->where('item', $item);
                         $payout->increment('quantity', $quantity);
                         $payout->increment('isk', $isk);

                     } else {
                         logger()->debug($character_name.'\'s payout doesn\'t exist.  '.$character->name.' looted '.$quantity.' of '.$item.' for '.$isk);
                         $payout = Payout::updateOrCreate(
                             ['character_name' => (string)$character->name, 'item' => $item],
                             ['quantity' => $quantity, 'isk' => $isk]
                         );
                     }
                    return $payout;
                else:
                    logger()->debug($character_name.' doesn\'t exist as a character');
                    return;
                endif;
            }
        }
    }


    //TODO: Remove dummy number and implement market data
    function getItemPrice( $item ) {
            $item2ElectricBoogaloo = InvType::where( 'typeName' , $item)->first();
            $price = $this->getHistoricalPrice($item2ElectricBoogaloo->typeID, carbon()->toDateString());
        return $price;
    }

     function getMainCharacter( $character ) {
          if ( is_object( $character ) ) {
               $user = $this->getUser($character->getKey());
               $group = $user->group;
               $main_ID = $group->main_character_id;
               return CharacterInfo::where('character_id', $main_ID)->first();
          }
     }

}