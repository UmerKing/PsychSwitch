<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Exception\RequestException;
use App\Http\Resources\TimingSlot as TimingSlotResource;
use Validator;
use App\TimingSlot;


class TimingSlotController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    /**
     * Create a new slot against doctor
     * @param Request $request
     * @return false|\Illuminate\Http\Response|string
     */
    public function add(Request $request)
    {
        try {
            $doctor = auth()->user();
            $input = $request->all();
            $input["doctor_id"] = $doctor->id;
            $validator = Validator::make($input, [
                'day' => 'required',
                'doctor_id' => 'required',
                'start_time' => 'required',
                'end_time' => 'required',
                'treatment_type' => 'required',
            ]);
            if ($validator->fails()) {
                return ResponseController::sendError('Validation Error.', $validator->errors())->content();
            } else {
                $timing_slot = TimingSlot::create($input);
                return ResponseController::sendResponse(new TimingSlotResource($timing_slot), 'Record created successfully.')->content();
            }
        } catch (RequestException $re) {
            // For handling exception.
            return json_encode($re);
        }
    }


    /**
     * get all slots against specified doctor_id.
     * @param null $doctor_id
     * @return \Illuminate\Http\Response
     */
    public function show($doctor_id = null)
    {
        $doctor = auth()->user();
        $doctor_id = $doctor_id ? $doctor_id : $doctor->id;
        //$data = Blog::find(1)->delete();
        $timing_slots = TimingSlot::where('doctor_id', $doctor_id)->withTrashed()->get();

        if (is_null($timing_slots)) {
            return $this->sendError('No Record found.');
        }
        return ResponseController::sendResponse(new TimingSlotResource($timing_slots), 'Data retrieved successfully.');
    }
}
