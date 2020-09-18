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
            return view('index');
        }
        return view('index');
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
