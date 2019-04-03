<?php
/**
 * Created by PhpStorm.
 * User: bitch
 * Date: 3/24/2019
 * Time: 10:05 PM
 */

namespace Fordav3\Seat\Payout\Validation;

use Illuminate\Foundation\Http\FormRequest;

class SavePayout extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        return [['fleetLog' => 'required|string'],['haulerList' => 'string']];
    }
}
