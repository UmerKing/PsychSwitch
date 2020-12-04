<?php

namespace App\Http\Controllers;

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Validator;
use URL;
use Session;
use Redirect;
use Input;
use Stripe\Error\Card;

class PaymentController extends Controller
{
    /**
     * @param Request $request
     * @return string
     * Process a new payment against new appointment
     */
    public function makePayment(Request $request)
    {
//        $input = $request->all();
//        $input = Arr::except($input, array('_token'));
        $stripe = \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        try {
            $token = \Stripe\Token::create([
                'card' => [
                    'number' => $request->get('card_num'),
                    'exp_month' => $request->get('expiry_month'),
                    'exp_year' => $request->get('expiry_year'),
                    'cvc' => $request->get('cvv'),
                ],
            ]);
            if (!isset($token['id'])) {
                return ResponseController::sendError('Invalid Token', 'Token id is not valid')->content();
            }
            $charge = \Stripe\Charge::create([
                'card' => $token['id'],
                'currency' => 'USD',
                'amount' => 100,
                'description' => 'Payment for new Appointment',
            ]);

            if ($charge['status'] == 'succeeded') {
                return ResponseController::sendResponse(true, 'Appointment is successfully booked, you will soon receive a confirmation email.')->content();

            } else {
                return ResponseController::sendError('Validation Error.', 'There has been an error in processing your billing information.')->content();
            }
        } catch (\Exception $e) {
            return ResponseController::sendError('Validation Error.', $e->getMessage())->content();
        } catch (\Cartalyst\Stripe\Exception\CardErrorException $e) {
            return ResponseController::sendError('Validation Error.', $e->getMessage())->content();
        } catch (\Cartalyst\Stripe\Exception\MissingParameterException $e) {
            return ResponseController::sendError('Validation Error.', $e->getMessage())->content();
        }
    }
}
