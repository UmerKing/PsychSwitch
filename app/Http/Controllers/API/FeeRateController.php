<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use App\FeeRates;
use Validator;
use App\Http\Resources\FeeRate as FeeRateResource;

class FeeRateController extends BaseController
{
    /**
     * get all rated against specified timing_slot_id.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($timing_slot_id)
    {
        $rates = FeeRates::where('timing_slot_id', $timing_slot_id)->withTrashed()->get();

        if (is_null($rates)) {
            return $this->sendError('No Record found.');
        }

        return $this->sendResponse(new FeeRateResource($rates), 'Data retrieved successfully.');
    }
}