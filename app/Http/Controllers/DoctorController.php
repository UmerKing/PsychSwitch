<?php

namespace App\Http\Controllers;
use App\DoctorProfile;
use App\User;
use Illuminate\Http\Request;

class DoctorController extends Controller
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
     * Update the specified doctor profile.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $doctor_profile = DoctorProfile::find($id);
        $user = User::find($doctor_profile["user_id"]);
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255','unique:users,email,'.$user->id],
            'phone' => ['integer','required'],
            'city_id' => ['required', 'integer'],
            'designation' => ['required'],
            'pmdc' => ['required'],
            'about_me' => ['string'],
            'speciality_id' => ['integer','required'],
        ]);
        $user->name = $request["name"];
        $user->email = $request["email"];
        $user->phone = $request["phone"];
        $user->city_id = $request["city_id"];
        if ($user->save()) {
            $request = $request->all();
            $doctor_profile->about_me = $request["about-me"];
            if ($doctor_profile->update($request)) {
                return redirect()->route('doctor.profile')->with('success','Your Profile is successfully updated.');
            } else {
                return redirect()->route('doctor.profile')->with('error','Their has been an error occurred while updating your profile, please try again or contact support.');
            }
        }
        else {
            return redirect()->route('doctor.profile')->with('error','Their has been an error occurred while updating your profile, please try again or contact support.');
        }
    }

    /**
     * load doctor profile view
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function profile()
    {
        $doctor = auth()->user();
        $doctor_profile = DoctorProfile::where('user_id', $doctor->id)->get();
        return view('doctor/profile',['doctor'=>$doctor, 'doctor_profile' => $doctor_profile[0]]);
    }

    /**
     * doctor's timing and fee rates view
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function timingsAndRates()
    {
        return view('doctor/timings-and-rates',['is_doctor'=>true]);
    }
}
