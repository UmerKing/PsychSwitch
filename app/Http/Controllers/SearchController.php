<?php

namespace App\Http\Controllers;

use Validator;
use App\User;
use Illuminate\Http\Request;


class SearchController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware(['auth', 'verified']);
    }

    public function search(Request $request)
    {
        $params = $request->all();

        $doctors_list = User::where('approved_at', '!=', Null);

        if (!empty($params['city_id']))
            $doctors_list = $doctors_list->where('city_id', $params['city_id']);
        if (!empty($params['speciality_id']))
            $doctors_list = $doctors_list->where('doctor_profiles.speciality_id', $params['speciality_id']);

        $doctors_list = $doctors_list->join('doctor_profiles', 'users.id', '=', 'doctor_profiles.user_id')
            ->join('specialities', 'specialities.id', '=', 'doctor_profiles.speciality_id')
            ->leftJoin('sub_specialities', 'sub_specialities.id', '=', 'doctor_profiles.sub_speciality_id')
            ->join('cities', 'cities.id', '=', 'users.city_id')
            ->select('users.*', 'doctor_profiles.*', 'specialities.name as speciality_name', 'sub_specialities.name as sub_speciality_name', 'cities.city')
            ->get();

        if ($doctors_list->isEmpty())
            return redirect()->route('search')->with('error', 'No record exist against your search parameters.');
        else
            return view('index', compact('doctors_list', 'params'));
    }
}