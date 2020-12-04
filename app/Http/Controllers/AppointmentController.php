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
                'phone' => 'required | integer',
                'appointment_date' => 'required',
                'card_num' => 'required',
                'expiry_month' => 'required',
                'expiry_year' => 'required',
                'cvv' => 'required',
                'amount' => 'required',
            ]);
            if ($validator->fails()) {
                return ResponseController::sendError('Validation Error.', $validator->errors())->content();
            } else {
                Appointments::create($input);
                $payment = new PaymentController();
                return $payment->makePayment($request);
            }
        } catch (RequestException $e) {
            // For handling exception.
            return ResponseController::sendError('Validation Error.', $e->getMessage())->content();
        }
    }
}
