<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
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
     * Show the application dashboard based on user role.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $doctors = User::whereNotNull('approved_at')->where("type", "doctor")->select('doctor_profiles.*', 'users.*', 'specialities.name as speciality_name')->
                   join("doctor_profiles",'doctor_profiles.user_id','=','users.id')->
                   join("specialities",'specialities.id','=','doctor_profiles.speciality_id')->get();
        if (Auth::check()) {
            $user = new User();
            if ($user->isAdmin()) {
                return view('admin/dashboard');
            } else if ($user->isDoctor()) {
                if (!auth()->user()->approved_at)
                    return view('auth/verify');
                else
                    return view('doctor/dashboard');
            }
            return view('index',compact('doctors'));
        }
        return view('index',compact('doctors'));
    }

    /**
     * If user is registered but not approved by admin then redirect with approval message
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function approval()
    {
        $user = auth()->user();
        if (is_null($user->approved_at)) {
            return view('auth/verify');
        } else {
            return redirect()->route('index')->withMessage('You are approved by the Admin User');
        }
    }
}
