<?php

namespace App\Http\Controllers;

use App\Appointments;
use Validator;
use Illuminate\Http\Request;
use GuzzleHttp\Exception\RequestException;


class AppointmentController extends Controller
{
    /**
     * save a new appointment
     * @param Request $request
     * @return false|\Illuminate\Http\Response|string
     */
    public function store(Request $request)
    {
        try {
            $input = $request->all();
            $validator = Validator::make($input, [
                'timing_slot_id' => 'required | integer',
                'name' => 'required | string',
                'email' => 'required',
                'phone' => 'required',
                'appointment_date' => 'required'
            ]);
            if ($validator->fails()) {
                return ResponseController::sendError('Validation Error.', $validator->errors())->content();
            } else {
                Appointments::create($input);
                return ResponseController::sendResponse(true, 'Information is submitted successfully, please complete the payment process to finalize your appointment.')->content();
            }
        } catch (RequestException $re) {
            // For handling exception.
            return json_encode($re);
        }
    }
}
