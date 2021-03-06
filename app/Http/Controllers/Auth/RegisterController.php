<?php

namespace App\Http\Controllers\Auth;

use App\DoctorProfile;
use App\Http\Controllers\Controller;
use App\Notifications\NewDoctorRegistered;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'phone' => ['required'],
            'city_id' => ['required', 'integer'],
            'designation' => ['string'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'type' => (int)$data['registered-as'] === User::DOCTOR ? User::DOCTOR_TYPE : User::PATIENT_TYPE,
            'phone' => $data['phone'],
            'city_id' => $data['city_id'],
            'approved_at' => (int)$data['registered-as'] === User::DOCTOR ? NULL : date('Y-m-d H:i:s')
        ]);

        if ((int)$data['registered-as'] === User::DOCTOR) {
            //create profile
            DoctorProfile::create([
                'designation' => $data['designation'],
                'pmdc' => $data['pmdc'],
                'user_id' => $user->id,
                'speciality_id' => $data['speciality_id'],
            ]);
            //send admin user email & alert
            $admins = User::where('type', User::ADMIN_TYPE)->get();
            if ($admins) {
                foreach ($admins as $admin) {
                    $admin->notify(new NewDoctorRegistered($user));
                }
            }
        }
        return $user;
    }
}
