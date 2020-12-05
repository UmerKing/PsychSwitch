<?php

namespace App\Http\Controllers;

use App\Appointments;
use App\Notifications\NewAppointment;
use App\User;
use Illuminate\Support\Facades\Mail;
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
                $appointment = Appointments::create($input);
                $payment = new PaymentController();
                $payment = $payment->makePayment($request);
                if(json_decode($payment)->success) {
                    return $this->confirmPayment($appointment->id, $input["doctor_id"]);
                }
                else {
                    return $payment;
                }
            }
        } catch (RequestException $e) {
            // For handling exception.
            return ResponseController::sendError('Validation Error.', $e->getMessage())->content();
        }
    }

    /**
     * @param $id
     * @return string
     * confirm payment in the DB
     */
    public function confirmPayment($id, $doctor_id) {
        try{
        $appointment = Appointments::find($id);
        $appointment->is_payment_completed = 1;
        $appointment->status = 'Payment Completed';
        if($appointment->save()) {
            $this->notifyDoctor($doctor_id);
            $this->confirmationEmail($appointment->email);
            return ResponseController::sendResponse(true, 'Appointment is successfully booked, you will soon receive a confirmation email.')->content();
        }
        else {
            return ResponseController::sendError('Validation Error.', 'Booking is successfully completed, but there is some internal server error occur please contact support if you did not get any email.')->content();
        }
        } catch (RequestException $e) {
            // For handling exception.
            return ResponseController::sendError('Validation Error.', $e->getMessage())->content();
        }
    }

    /**
     * @param $id
     * @param $status
     * @return string
     * update status
     */
    public function updateStatus($id,$status) {
        $appointment = Appointments::find($id);
        $appointment->status = $status;
        $appointment->save();
        if($appointment->save()) {
            return ResponseController::sendResponse(true, 'Status is successfully updated.')->content();
        }
        else {
            return ResponseController::sendError('Validation Error.', 'There has been an error in updating the status.')->content();
        }
    }

    /**
     * @param $doctor_id
     * Notify doctor about a new appointment
     */
    public function notifyDoctor($doctor_id) {
        $doctors = User::where('id', $doctor_id)->get();
        foreach ($doctors as $doctor) {
            $doctor->notify(new NewAppointment());
        }
    }

    /**
     * @param $email
     * Send patient confirmation email
     */
    public function confirmationEmail($email) {
        $data = array('name'=>"PsychSwitch");
        Mail::send([], $data, function($message) use ($email) {
            $message->to($email, 'PsychSwitch')->subject
            ('Confirmation Email');
            $message->setBody('Appointment is successfully booked');
            $message->from(env('MAIL_USERNAME'),'PsychSwitch');
        });
    }
}
