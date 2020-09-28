<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use App\SubSpecialities;
use Validator;
use App\Http\Resources\SubSpeciality as SubSpecialityResource;

class SubSpecialityController extends BaseController
{
    /**
     * get all the sub specialities
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sub_specialities = SubSpecialities::all();

        return $this->sendResponse(SubSpecialityResource::collection($sub_specialities), 'Sub Specialities retrieved successfully.');
    }

    /**
     * get sub specialities against specified speciality_id.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($speciality_id)
    {
        $sub_speciality = SubSpecialities::where('speciality_id', $speciality_id)->get();

        if (is_null($sub_speciality)) {
            return $this->sendError('Sub Speciality not found.');
        }

        return $this->sendResponse(new SubSpecialityResource($sub_speciality), 'Sub Speciality retrieved successfully.');
    }
}