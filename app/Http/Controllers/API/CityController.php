<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use App\Cities;
use Validator;
use App\Http\Resources\City as CityResource;

class CityController extends BaseController
{
    /**
     * retrieve all cities
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cities = Cities::all();

        return $this->sendResponse(CityResource::collection($cities), 'Cities retrieved successfully.');
    }


    /**
     * retrieve city against give id
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $city = Cities::find($id);

        if (is_null($city)) {
            return $this->sendError('City not found.');
        }

        return $this->sendResponse(new CityResource($city), 'City retrieved successfully.');
    }
}