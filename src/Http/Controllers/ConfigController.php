<?php
/**
 * Created by PhpStorm.
 * User: bitch
 * Date: 4/3/2019
 * Time: 7:44 PM
 */

namespace Fordav3\Seat\Payout\Http\Controllers;


use Fordav3\Seat\Payout\Validation\FixedPriceRequest;
use http\Env\Request;
use Fordav3\Seat\Payout\Models\FixedPayout;
use Seat\Web\Http\Controllers\Controller;


class ConfigController extends Controller
{


    public function index(FixedPriceRequest $request)
    {
        $amounts = FixedPayout::all();

        return view('payout::config', ['entries' => $amounts]);
    }

    public function save(FixedPriceRequest $request)
    {

        $type = $request->type;
        switch ($type)
        {
            case 'create':
                $this->create($request->item, $request->isk);
                break;
            case 'change':
                $this->change($request->item, $request->isk);
                break;
            case 'remove':
                $this->remove($request->item);
                break;

        }
        $entries = FixedPayout::all();
        return view('payout::config', compact('entries'));
    }

    public function create($item, $isk)
    {
        FixedPayout::firstOrCreate(['item' => $item], ['isk'=>$isk]);
    }
    public function change($item, $isk)
    {
        FixedPayout::where('item', $item)->update(['isk'=>$isk]);
    }
    public function remove($item)
    {
        FixedPayout::destroy($item);
    }

}