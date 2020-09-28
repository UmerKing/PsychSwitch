<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DoctorProfile extends Model
{
    protected $fillable = [
        'address', 'designation', 'pmdc','about_me','avatar','user_id', 'speciality_id', 'sub_speciality_id'
    ];

}
