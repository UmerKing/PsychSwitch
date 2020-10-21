@extends('doctor.layouts.app')
@section('content')
    <!-- Page content -->
    <!-- Page content -->
    <div class="row" id="doctor-profile" style="margin: 0">
        <div class="col-xl-12 order-xl-2 mb-5 mb-xl-0">
            <div class="card card-profile shadow">
                <div class="card-header text-center border-0 pt-8 pt-md-4 pb-0 pb-md-4">
                    <div class="d-flex justify-content-between">
                        Available Time Slots and Fee rates
                    </div>
                </div>
                <div class="card-body pt-0 pt-md-4">
                    @csrf
                    <h6 class="heading-small text-muted mb-4">Add New Slot</h6>
                    <div class="pl-lg-4">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group focused">
                                    <label class="form-control-label" for="input-day">Day</label>
                                    <select class="form-control @error('day') is-invalid @enderror" id="day"
                                            name="day" autocomplete="day">
                                        <option value="1">Monday</option>
                                        <option value="2">Tuesday</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="form-control-label" for="input-timing">Timing</label>
                                    <input type="text" id="timing" name="timing"
                                           class="form-control form-control-alternative" value="">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="form-control-label" for="input-treatment-type">Treatment Type</label>
                                    <select class="form-control @error('treatment_type') is-invalid @enderror"
                                            id="treatment_type"
                                            name="treatment_type" autocomplete="treatment_type">
                                        <option value="1">Video call</option>
                                        <option value="2">In Clinic</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row align-items-center">
                            <div class="col-8">
                                {{--<h3 class="mb-0">My Profile</h3>--}}
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
            </div>
        </div>
    </div>
@endsection