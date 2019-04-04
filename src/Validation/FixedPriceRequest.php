<?php
/**
 * Created by PhpStorm.
 * User: bitch
 * Date: 4/3/2019
 * Time: 8:07 PM
 */

namespace Fordav3\Seat\Payout\Validation;

use Fordav3\Seat\Payout\Models\FixedPayout;
use Illuminate\Foundation\Http\FormRequest;

class FixedPriceRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        return [['type'=>'required|string'],['item'=>'required|string'],['isk' => 'integer']];
    }
}