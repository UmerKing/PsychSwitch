<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use GuzzleHttp\Client as GuzzleHttpClient;
use GuzzleHttp\Exception\RequestException;


class TimingSlotController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth','verified']);
    }

    /**
     * Create a new slot against doctor
     * @param Request $request
     * @return false|string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function add(Request $request)
    {
        $doctor = auth()->user();
        $requestContent = [
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ],
            'json' => [
                'doctor_id' => $doctor->id,
                'day' => $request["day"],
                'start_time' => $request["start_time"],
                'end_time' => $request["end_time"],
                'treatment_type' => $request["treatment_type"],
            ]
        ];

        try {
            $client = new GuzzleHttpClient();
            $apiRequest = $client->request('POST', config("app.api_url").'api/timing_slots', $requestContent);
            return json_encode(json_decode($apiRequest->getBody()));
        } catch (RequestException $re) {
            // For handling exception.
            return json_encode($re);
        }
    }
}
