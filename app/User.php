<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;
    const ADMIN_TYPE = 'admin';
    const DOCTOR_TYPE = 'doctor';
    const PATIENT_TYPE = 'patient';
    const DOCTOR = 1;
    const PATIENT = 2;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','type','phone','city_id', 'designation', 'speciality_id', 'sub_speciality_id','pmdc','approved_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Check if user is admin user
     * @return bool
     */
    public function isAdmin()    {
        $user = auth()->user();
        return $user->type === self::ADMIN_TYPE;
    }
}
