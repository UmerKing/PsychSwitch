<?php

namespace App\Http\Controllers\Admin\Doctors;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class DoctorsController extends Controller
{

    /**
     * get all registered doctors and display them in datatable at the frontend
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function registered() {
        $doctors = DB::table('users')->where('email_verified_at','!=',NULL)->get();
        return \view('admin/doctors/registered',compact('doctors'));
    }

    /**
     * get all non-registered doctors and display them in datatable at the frontend
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function unconfirmed() {
        $doctors = DB::table('users')->where('email_verified_at',NULL)->get();
        return \view('admin/doctors/unconfirmed',compact('doctors'));
    }
}
