<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Notifications\Messages\MailMessage;

class PatientController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware(['auth','verified']);
    }

    /**
     * approve registration of patient when they click on url from email
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function confirmRegistration($patient_id)
    {
        $user = User::findOrFail($patient_id);
        $user->update(['approved_at' => now()]);
        return redirect()->route('home')->withMessage('Registration approved successfully');
    }

    /**
     * send email to patient to confirm registration
     * @param $patient_user
     * @return MailMessage
     */
    public function toMail($patient_user)
    {
        return (new MailMessage)
            ->line('You created your account with email ' . $patient_user->email)
            ->action('Confirm Registration', route('confirmRegistration', $patient_user->id));
    }
}
