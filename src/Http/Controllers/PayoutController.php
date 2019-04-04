<?php

namespace Fordav3\Seat\Payout\Http\Controllers;
use Fordav3\Seat\Payout\Models\FixedPayout;
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
        $filter = explode(",",$request->filter);
        logger()->debug('Haulers: '.$haulers);
        $logarray = explode("\n", $fleetlog);
        $haulerarray = explode(",", $haulers);
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
        return view('payout::payout', compact('payouts', 'haulerarray', 'filter'));
    }

    function buildPayout( $entry , $haulers)
    {
        $formats = array(
            'window' => '#^(?<stamp>[\d:]*)?\s(?<charname>.*?)\shas looted\s(?<quantity>(\d|,)*)\sx\s(?<item>.*?)$#',
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
               // logger()->debug($character_name);
                //logger()->debug($haulers);
                if(stripos(json_encode($haulers),$character_name) !== false) : logger()->debug($character_name.' is a hauler, ignoring');break; return;
                else: logger()->debug($character_name.' is not a hauler');
                endif;
                if($character = CharacterInfo::where('name', $character_name)->first()) : $name = $this->getMainCharacter($character)->name;
                else : $name = $character_name;
                endif;
                    $quantity = $values['quantity'];
                    $quantity = filter_var($quantity, FILTER_SANITIZE_NUMBER_INT);

                    $isk = $this->getItemPrice($item) * $quantity;
                    if (Payout::where([['character_name', $name], ['item', $item]])->exists()) {
                   //      logger()->debug($character_name.'\'s payout exists, getting and setting the payout.  '.$name.' looted '.$quantity.' of '.$item.' for '.$isk);
                         $payout = Payout::where('character_name', $name)->where('item', $item);
                         $payout->increment('quantity', $quantity);
                         $payout->increment('isk', $isk);

                    } else {
                  //       logger()->debug($character_name.'\'s payout doesn\'t exist.  '.$name.' looted '.$quantity.' of '.$item.' for '.$isk);
                         $payout = Payout::updateOrCreate(
                             ['character_name' => (string)$name, 'item' => $item],
                             ['quantity' => $quantity, 'isk' => $isk]
                         );
                    }
             //       logger()->debug($name.' is paid out');
                    return $payout;

            }
        }
    }


     function getItemPrice( $item ) {

         //$price_overrides = array(             'Blue Ice' => 273000         );
          $item2ElectricBoogaloo = InvType::where( 'typeName' , $item)->first();
          $price = $this->getHistoricalPrice($item2ElectricBoogaloo->typeID, carbon()->toDateString())->average_price;
          if ($price_overrides = FixedPayout::where('item', $item)->first() ) {
               $price = $price_overrides->isk;
          }
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
