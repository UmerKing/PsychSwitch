@extends('admin.layouts.doctor')
@section('styles')
    <link rel="stylesheet" href="{{ asset('css/doctor_profile.css') }}">
@stop
@section('content')
    <!-- Page content -->
    <div class="row" id="doctor-profile" style="margin:0">
        <div class="col-xl-4 order-xl-2 mb-5 mb-xl-0">
            <div class="card card-profile shadow">
                <div class="row justify-content-center">
                    <div class="col-lg-3 order-lg-2">
                        <div class="card-profile-image">
                            <a href="#">
                                <img src="{{ asset('images/'. $doctor_profile["avatar"]) }}" class="rounded-circle">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-header text-center border-0 pt-8 pt-md-4 pb-0 pb-md-4">
                    <div class="d-flex justify-content-between">
                    </div>
                </div>
                <div class="card-body pt-0 pt-md-4">
                    <div class="row">
                        <div class="col">
                            <div class="card-profile-stats d-flex justify-content-center mt-md-5">
                                <div>
                                    <span class="heading">22</span>
                                    <span class="description">Clients</span>
                                </div>
                                <div>
                                    <span class="heading">10</span>
                                    <span class="description">Photos</span>
                                </div>
                                <div>
                                    <span class="heading">89</span>
                                    <span class="description">Reviews</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <h3>
                            {{$doctor->name}}<span class="font-weight-light"></span>
                        </h3>
                        <div class="h5 font-weight-300">
                            <i class="ni location_pin mr-2"></i>@{{ city_name }}
                        </div>
                        <div class="h5 mt-4">
                            <i class="ni business_briefcase-24 mr-2"></i>{{$doctor_profile["designation"]}}
                        </div>
                        <div>
                            <i class="ni education_hat mr-2"></i>University of Computer Science
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-8 order-xl-1">
            <div class="alert alert-danger" v-if="is_error_thrown" v-cloak>
                <ul>
                    <li v-for="error in errors">@{{ error.message }}</li>
                </ul>
            </div>
            @include('flash-message')
            <div>
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{$doctor["name"] . " Profile"}}</h3>
                            </div>
                            <div class="col-4 text-right">
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @csrf
                        <h6 class="heading-small text-muted mb-4">Personal information</h6>
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="input-username">Name</label>
                                        <input type="text" id="name" name="name"
                                               class="form-control form-control-alternative" placeholder="Username"
                                               value="{{$doctor["name"]}}" readonly>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-email">Email address</label>
                                        <input type="email" id="email" name="email"
                                               class="form-control form-control-alternative"
                                               value="{{$doctor["email"]}}" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="input-first-name">Phone</label>
                                        <input type="text" id="phone" name="phone"
                                               class="form-control form-control-alternative @error('phone') is-invalid @enderror"
                                               placeholder="First name" value="{{$doctor->phone}}" readonly>
                                        @error('phone')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="input-last-name">City</label>
                                        <select class="form-control @error('city_id') is-invalid @enderror" id="city_id"
                                                name="city_id" autocomplete="city_id" required disabled>
                                            <option v-for="city in cities" v-bind:value="city.id"
                                                    :selected="city.id == {{ $doctor["city_id"] }} ? true : false ">@{{
                                                city.city }}
                                            </option>
                                        </select>
                                        @error('city_id')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="input-address">Address</label>
                                        <input id="address" class="form-control form-control-alternative" name="address"
                                               placeholder="Home Address" value="{{$doctor_profile['address']}}"
                                               type="text" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr class="my-4">
                        <!-- Address -->
                        <h6 class="heading-small text-muted mb-4">Professional information</h6>
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="input-first-name">Speciality</label>
                                        <select class="form-control" id="speciality_id" name="speciality_id"
                                                v-on:change="getSubSpecialities"
                                                autocomplete="speciality_id" disabled>
                                            <option v-for="speciality in specialities"
                                                    v-bind:value="speciality.id"
                                                    :selected="speciality.id == {{ $doctor_profile['speciality_id'] }} ? true : false ">
                                                @{{ speciality.name }}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="input-last-name">Sub Speciality</label>
                                        <select class="form-control @error('sub_speciality_id') is-invalid @enderror"
                                                id="city_id"
                                                name="sub_speciality_id" autocomplete="sub_speciality_id" disabled>
                                            <option v-for="sub_speciality in sub_specialities"
                                                    v-bind:value="sub_speciality.id">@{{ sub_speciality.name }}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="designation">Designation</label>
                                        <input type="text" id="designation"
                                               class="form-control form-control-alternative" name="designation"
                                               placeholder="Designation" value="{{$doctor_profile['designation']}}"
                                               readonly>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="pmdc">PMDC</label>
                                        <input type="text" id="pmdc" class="form-control form-control-alternative"
                                               name="pmdc" placeholder="PMDC" value="{{$doctor_profile['pmdc']}}"
                                               readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr class="my-4">
                        <!-- Description -->
                        <h6 class="heading-small text-muted mb-4">About me</h6>
                        <div class="pl-lg-4">
                            <div class="form-group focused">
                                <label>About Me</label>
                                <textarea rows="4" name="about-me" class="form-control form-control-alternative"
                                          placeholder="A few words about you ..."
                                          readonly>{{$doctor_profile['about_me']}}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection