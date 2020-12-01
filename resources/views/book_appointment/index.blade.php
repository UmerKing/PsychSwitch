@extends('layouts.app')
@section('styles')
    <link rel="stylesheet" href="{{ asset('theme/css/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('theme/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('theme/css/nice-select.css') }}">
    <link rel="stylesheet" href="{{ asset('theme/css/slicknav.css') }}">
    <link rel="stylesheet" href="{{ asset('theme/css/style.css') }}">
    <script src="{{ asset('theme/js/main.js')}}" defer></script>
    @stop

@section('content')
<!--[if lte IE 9]>
    <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a
            href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
    <![endif]-->

    <div class="bradcam_area breadcam_bg bradcam_overlay">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="bradcam_text">
                        <h3>Book Appointment</h3>
                        <p><a href="/">Home /</a> Book Appointment</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="whole-wrap" id="page-book-appointment">
        <div class="container box_1170">
            <div class="section-top-border">
                <h3 class="mb-30">Doctors/{{$doctor->name}}</h3>
                <div class="row">
                    <div class="col-md-3">
                        <img src="{{asset('images/'.$doctor->avatar)}}" alt="" class="img-fluid"
                             data-pagespeed-url-hash="1782135495">
                        <p>{{$doctor->name}} from {{$doctor->city}}, {{$doctor->designation}} </p>
                        <p>Specialist in {{$doctor->speciality_name}}</p>
                        <p>{{$doctor->about_me}}</p>
                    </div>
                    <div class="col-md-9 mt-sm-20">
                        <button href="#" class="genric-btn success circle e-large"
                                v-if="!is_booking_active && !is_payment_active"
                                v-on:click="activateBooking(true)">Book Appointment
                        </button>
                        <div class="alert alert-danger alert-block" v-if="is_error" v-cloak>
                            <ul>
                                <li v-for="message in messages">@{{ message.message }}</li>
                            </ul>
                        </div>
                        <div class="alert alert-success alert-block" v-if="data_success" v-cloak>
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            <strong>@{{ success_message }}</strong>
                        </div>
                        <form v-on:submit.prevent="submitForm">
                            @csrf
                            <div class="row" v-if="is_booking_active && !is_payment_active">
                                <div class="col-lg-12 col-md-12">
                                    <div class="mt-10 row">
                                        <div class="col col-lg-6 col-md-6">
                                            <label class="form-control-label" for="input-date">Choose Date</label>
                                            <input type="date"
                                                   v-on:change="getAvailableTimeSlots('{{$doctor->id}}', $event)"
                                                   class="form-control time-picker" id="date-picker" width="276"
                                                   name="date" v-model="form.appointment_date"/>
                                        </div>
                                        <div class="col col-lg-6 col-md-6">
                                            <label class="form-control-label" for="input-time-slots">Available Time
                                                Slots</label>
                                            <select class="form-control" id="time-slots" required
                                                    name="time-slots" v-on:change="filterTypes($event)">
                                                <option value="">Please Select time slot</option>
                                                <option v-for="data in time_slots">@{{ data.start_time }} - @{{
                                                    data.end_time }}
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mt-10 row">
                                        <div class="col col-lg-6 col-md-6">
                                            <label class="form-control-label" for="input-type">Treatment Type</label>
                                            <select class="form-control" id="type" required
                                                    name="type" autocomplete="type">
                                                <option v-for="data in treatment_types" v-bind:value="data.id">@{{
                                                    data.treatment_type == "1" ? "Video Call" : "In Clinic" }}
                                                </option>
                                            </select>
                                        </div>
                                        <div class="col col-lg-6 col-md-6">
                                            <label>Your Name</label>
                                            <input type="text" name="name" placeholder="name"
                                                   onfocus="this.placeholder = ''"
                                                   onblur="this.placeholder = 'Your Name'" required
                                                   class="single-input" v-model="form.name">
                                        </div>
                                    </div>
                                    <div class="mt-10 row">
                                        <div class="col col-lg-6 col-md-6">
                                            <label>Email</label>
                                            <input type="email" name="email" placeholder="Email"
                                                   onfocus="this.placeholder = ''"
                                                   onblur="this.placeholder = 'Email'" required
                                                   class="single-input" v-model="form.email">
                                        </div>
                                        <div class="col col-lg-6 col-md-6">
                                            <label>Phone Number</label>
                                            <input type="text" name="phone" placeholder="Phone Number"
                                                   onfocus="this.placeholder = ''"
                                                   onblur="this.placeholder = 'phone'" required
                                                   class="single-input" v-model="form.phone">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button href="#" class="genric-btn success circle mt-10"
                                    v-if="is_booking_active && !is_payment_active"
                            >Book Appointment
                            </button>
                            <button href="#" class="genric-btn danger circle mt-10"
                                    v-if="is_booking_active && !is_payment_active"
                                    v-on:click="activateBooking(false)">Cancel
                            </button>
                        </form>
                        <form v-if="is_payment_active">
                            Payment form
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include("inc/_footer");
@endsection