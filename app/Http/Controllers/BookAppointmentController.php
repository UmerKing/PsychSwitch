<?php

namespace App\Http\Controllers;

use App\User;

class BookAppointmentController extends Controller
{
    /**
     * @param $id
     * get doctor profile and information to display on booking page for the user to book his appointment
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index($id)
    {
        $doctor = User::whereNotNull('approved_at')->where("type", "doctor")->where("users.id", $id)->select(
            'doctor_profiles.designation', 'doctor_profiles.about_me', 'doctor_profiles.avatar', 'users.name', 'users.id', 'specialities.name as speciality_name', 'cities.city'
        )->join("doctor_profiles", 'doctor_profiles.user_id', '=', 'users.id')->join("specialities", 'specialities.id', '=', 'doctor_profiles.speciality_id')->
        join("cities", 'cities.id', '=', 'users.city_id')->get();
        return view("book_appointment/index", ["doctor" => $doctor[0]]);
    }
}
