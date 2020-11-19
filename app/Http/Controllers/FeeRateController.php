<?php

namespace App\Http\Controllers;

use App\FeeRates;
use Illuminate\Http\Request;

class FeeRateController extends Controller
{
    /**
     * save or update fee rate against specific slot
     * @param Request $request
     * @return false|\Illuminate\Http\Response|string
     */
    public static function store($input)
    {
        $input["timing_slot_id"] = $input["id"];
        unset($input["id"]);
        if ($input["rate_id"]) {
            $rate = FeeRates::find($input["rate_id"]);
            $rate->update($input);
        } else
            FeeRates::create($input);

        return true;

    }
}
