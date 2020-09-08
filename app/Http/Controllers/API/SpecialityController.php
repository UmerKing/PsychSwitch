<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Specialities;
use Validator;
use App\Http\Resources\Speciality as SpecialityResource;

class SpecialityController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $specialities = Specialities::all();

        return $this->sendResponse(SpecialityResource::collection($specialities), 'Specialities retrieved successfully.');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $speciality = Specialities::create($input);

        return $this->sendResponse(new SpecialityResource($speciality), 'Speciality created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $speciality = Specialities::find($id);

        if (is_null($speciality)) {
            return $this->sendError('Speciality not found.');
        }

        return $this->sendResponse(new SpecialityResource($speciality), 'Speciality retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Specialities $speciality)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required',
            'detail' => 'required'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $speciality->name = $input['name'];
        $speciality->save();

        return $this->sendResponse(new SpecialityResource($speciality), 'Speciality updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Specialities $speciality)
    {
        $speciality->delete();

        return $this->sendResponse([], 'Speciality deleted successfully.');
    }
}