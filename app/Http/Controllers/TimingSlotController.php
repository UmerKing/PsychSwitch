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
     * Create a new slot or update existing slot against doctor
     * @param Request $request
     * @return false|\Illuminate\Http\Response|string
     */
    public function store(Request $request)
    {
        try {
            $doctor = auth()->user();
            $input = $request->all();
            $input["doctor_id"] = $input["doctor_id"] ? $input["doctor_id"] : $doctor->id;
            $validator = Validator::make($input, [
                'day' => 'required',
                'doctor_id' => 'required',
                'start_time' => 'required',
                'end_time' => 'required',
                'treatment_type' => 'required',
                'rate' => $input["is_doctor"] ? '' : 'required'
            ]);
            if ($validator->fails()) {
                return ResponseController::sendError('Validation Error.', $validator->errors())->content();
            } else {
                if ($input["id"]) { //if request for updating the record
                    $slot = TimingSlot::find($input["id"]);
                    $slot->update($input);
                    if(!$input["is_doctor"]) { //if request of update is from admin view
                        FeeRateController::store($input);
                    }
                    return ResponseController::sendResponse($this->show($input["doctor_id"], false), 'Record updated successfully.')->content();
                } else { //if request is to create new record
                    $timing_slot = TimingSlot::create($input);
                    return ResponseController::sendResponse($this->show($input["doctor_id"], false), 'Record created successfully.')->content();
                }
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
    public function show($doctor_id = null, $formatted_json = true)
    {
        try {
            $doctor = auth()->user();
            $doctor_id = $doctor_id ? $doctor_id : $doctor->id;
            //$data = Blog::find(1)->delete();
            $timing_slots = TimingSlot::leftJoin('fee_rates', 'fee_rates.timing_slot_id', '=', 'timing_slots.id')->select('timing_slots.*', 'fee_rates.id as rate_id','fee_rates.rate')->where('timing_slots.doctor_id', $doctor_id)
                ->withTrashed()->get();

            if (is_null($timing_slots)) {
                return $this->sendError('No Record found.');
            }
            //prepare array of all days with time
            $response = [];
            $response["monday"] = array_values(array_filter($timing_slots->toArray(), function ($elem) {
                return $elem["day"] == "MONDAY";
            }));
            $response["tuesday"] = array_values(array_filter($timing_slots->toArray(), function ($elem) {
                return $elem["day"] == "TUESDAY";
            }));
            $response["wednesday"] = array_values(array_filter($timing_slots->toArray(), function ($elem) {
                return $elem["day"] == "WEDNESDAY";
            }));
            $response["thursday"] = array_values(array_filter($timing_slots->toArray(), function ($elem) {
                return $elem["day"] == "THURSDAY";
            }));
            $response["friday"] = array_values(array_filter($timing_slots->toArray(), function ($elem) {
                return $elem["day"] == "FRIDAY";
            }));
            $response["saturday"] = array_values(array_filter($timing_slots->toArray(), function ($elem) {
                return $elem["day"] == "SATURDAY";
            }));
            $response["sunday"] = array_values(array_filter($timing_slots->toArray(), function ($elem) {
                return $elem["day"] == "SUNDAY";
            }));
            if(!$formatted_json)
                return $response;

            return ResponseController::sendResponse($response, 'Data retrieved successfully.');
        } catch (RequestException $re) {
            // For handling exception.
            return json_encode($re);
        }
    }
}
