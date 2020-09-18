<?php

namespace App\Http\Controllers;
use App\User;

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
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        echo 'ddd';
    }

    public function profile()
    {
        $doctor = auth()->user();
        return view('doctor/profile',['doctor'=>$doctor]);
    }
}
