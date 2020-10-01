<?php

namespace App\Http\Controllers\Admin\Doctors;

use App\DoctorProfile;
use App\Http\Controllers\Controller;
use App\User;

class DoctorsController extends Controller
{

    /**
     * get all registered doctors and display them in datatable at the frontend
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function registered() {
        $doctors = User::whereNotNull('approved_at')->where("type", "doctor")->get();
        return \view('admin/doctors/registered',compact('doctors'));
    }

    /**
     * get all non-registered doctors and display them in datatable at the frontend
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function unconfirmed() {
        $doctors = User::whereNull('approved_at')->where("type", "doctor")->get();
        return \view('admin/doctors/unconfirmed',compact('doctors'));
    }

    /**
     * view doctor's profile
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function profile($id) {
        $doctor = User::where('id', $id)->get();
        $doctor_profile = DoctorProfile::where('user_id', $id)->get();
        return view('admin/doctors/profile',['doctor'=>$doctor[0], 'doctor_profile' => $doctor_profile[0]]);
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
        return redirect()->route('admin.doctors.unconfirmed')->withMessage('Doctor approved successfully');
    }

    /**
     * Mark notification as read when admin clicks on the notification
     * @param $notification_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function markRead($notification_id) {
        if(!is_null($notification_id)) {
            foreach (auth()->user()->unreadNotifications as $notification) {
                if ($notification->id === $notification_id) {
                    $current_notification = $notification;
                }
            }
            $current_notification->markAsRead();
        }
        return redirect()->route('admin.doctors.unconfirmed');
    }
}
