<?php

namespace App\Http\Controllers\Admin\Doctors;

use App\Http\Controllers\Controller;
use App\User;

class DoctorsController extends Controller
{

    /**
     * get all registered doctors and display them in datatable at the frontend
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function registered() {
        $doctors = User::whereNotNull('approved_at')->get();
        return \view('admin/doctors/registered',compact('doctors'));
    }

    /**
     * get all non-registered doctors and display them in datatable at the frontend
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function unconfirmed() {
        $doctors = User::whereNull('approved_at')->get();
        return \view('admin/doctors/unconfirmed',compact('doctors'));
    }

    /**
     * approve action for admin user to approve new doctors
     * @param $user_id
     * @return mixed
     */
    public function approve($doctor_id)
    {
        $user = User::findOrFail($doctor_id);
        $user->update(['approved_at' => now()]);
        return redirect()->route('admin.doctors.unconfirmed')->withMessage('User approved successfully');
    }
}
