@extends('doctor.layouts.app')
@section('content')
    <!-- Page content -->
    <!-- Page content -->
    <div class="row" id="timing-slots-view" style="margin: 0">
        <div class="col-xl-12 order-xl-2 mb-5 mb-xl-0">
            <div class="card card-timing-slot shadow">
                <div class="card-header text-center border-0 pt-8 pt-md-4 pb-0 pb-md-4">
                    <div class="d-flex justify-content-between">
                        Available Time Slots and Fee rates
                    </div>
                </div>
                <form v-on:submit.prevent="submitForm">
                    <div class="card-body pt-0 pt-md-4">
                        @csrf
                        <div class="alert alert-danger" v-if="is_error_thrown" v-cloak>
                            <ul>
                                <li v-for="message in messages">@{{ message.message }}</li>
                            </ul>
                        </div>
                        <div class="alert alert-success alert-block" v-if="data_success" v-cloak>
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            <strong>New Record has been created successfully.</strong>
                        </div>
                        <h6 class="heading-small text-muted mb-4">Add New Slot</h6>
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="input-day">Day</label>
                                        <select class="form-control" id="day"
                                                name="day" autocomplete="day" v-model="form.day">
                                            <option value="MONDAY">Monday</option>
                                            <option value="TUESDAY">Tuesday</option>
                                            <option value="WEDNESDAY">Wednesday</option>
                                            <option value="THURSDAY">Thursday</option>
                                            <option value="FRIDAY">Friday</option>
                                            <option value="SATURDAY">Saturday</option>
                                            <option value="SUNDAY">Sunday</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-start-time">Timing</label>
                                        <div class="form-control timepicker">
                                            <input class="time-picker start-time" id="start-time" width="276" name="start-time"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-end-time">Timing</label>
                                        <div class="form-control timepicker">
                                            <input class="time-picker end-time" id="end-time" width="276" name="end-time"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-treatment-type">Treatment
                                            Type</label>
                                        <select class="form-control @error('treatment_type') is-invalid @enderror"
                                                id="treatment_type"
                                                name="treatment_type" autocomplete="treatment_type" v-model="form.treatment_type">
                                            <option value="1">Video call</option>
                                            <option value="2">In Clinic</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row align-items-center">
                                <div class="col-8">
                                </div>
                                <div class="col-4 text-right">
                                    <button type="submit" class="btn btn-sm btn-primary">
                                        {{ __('Add') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                        <hr class="my-4">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                <tr>
                                    <th>Monday</th>
                                    <th>Tuesday</th>
                                    <th>Wednesday</th>
                                    <th>Thursday</th>
                                    <th>Friday</th>
                                    <th>Saturday</th>
                                    <th>Sunday</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>e</td>
                                    <td>e</td>
                                    <td>e</td>
                                    <td>e</td>
                                    <td>e</td>
                                    <td>e</td>
                                    <td>
                                        <a href="" class="btn btn-primary btn-sm">
                                            View
                                        </a>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection