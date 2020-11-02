<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use App\TimingSlot;
use Illuminate\Http\Request;
use Validator;
use App\Http\Resources\TimingSlot as TimingSlotResource;

class TimingSlotController extends BaseController
{
    /**
     * get all the available slots
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $timing_slots = TimingSlot::all();

        return $this->sendResponse(TimingSlotResource::collection($timing_slots), 'Timing Slots retrieved successfully.');
    }

    /**
     * create a new timing slot
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'day' => 'required',
            'doctor_id' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
            'treatment_type' => 'required',
        ]);
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors())->content();
        }
        $timing_slot = TimingSlot::create($input);
        return $this->sendResponse(new TimingSlotResource($timing_slot), 'Record created successfully.')->content();
    }

    /**
     * get all slots against specified doctor_id.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($doctor_id)
    {
        //$data = Blog::find(1)->delete();
        $timing_slots = TimingSlot::where('doctor_id', $doctor_id)->withTrashed()->get();

        if (is_null($timing_slots)) {
            return $this->sendError('No Record found.');
        }

        return $this->sendResponse(new TimingSlotResource($timing_slots), 'Data retrieved successfully.');
    }
}