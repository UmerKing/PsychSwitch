@extends('doctor.layouts.app')
@section('content')
    <!-- Page content -->
    <div class="row" id="timing-slots-view" style="margin: 0">
        <div class="col-xl-12 order-xl-2 mb-5 mb-xl-0">
            <div class="card card-timing-slot shadow">
                <div class="card-header text-center border-0 pt-8 pt-md-4 pb-0 pb-md-4">
                    <div class="d-flex justify-content-between">
                        Available Time Slots and Fee rates
                    </div>
                </div>
                <div class="card-body pt-0 pt-md-4">
                    @if($is_doctor)
                        <button type="button" class="btn btn-primary btn-sm mb-2" data-toggle="modal"
                                data-target=".bd-example-modal-lg">Add Slot
                        </button>
                    @endif
                    <table class="table table-striped table-responsive">
                        <tbody>
                        <tr>
                            <th scope="row" width="50">Monday</th>
                            <td colspan="3">
                                <div v-if="time_slots.monday && time_slots.monday.length">
                                    <div class="badge badge-pill badge-primary" data-toggle="modal"
                                         data-target=".bd-example-modal-lg" v-for="data in time_slots.monday"
                                         v-on:click="showDetail(data)">@{{ formatData(data) }}
                                    </div>
                                </div>
                                <div v-else>
                                    No record found
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Tuesday</th>
                            <td colspan="3">
                                <div v-if="time_slots.monday && time_slots.tuesday.length">
                                    <div class="badge badge-pill badge-primary" data-toggle="modal"
                                         data-target=".bd-example-modal-lg" v-for="data in time_slots.tuesday"
                                         v-on:click="showDetail(data)">@{{ formatData(data) }}
                                    </div>
                                </div>
                                <div v-else>
                                    No record found
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Wednesday</th>
                            <td colspan="3">
                                <div v-if="time_slots.monday && time_slots.wednesday.length">
                                    <div class="badge badge-pill badge-primary" data-toggle="modal"
                                         data-target=".bd-example-modal-lg" v-for="data in time_slots.wednesday"
                                         v-on:click="showDetail(data)">@{{ formatData(data) }}
                                    </div>
                                </div>
                                <div v-else>
                                    No record found
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Thursday</th>
                            <td colspan="3">
                                <div v-if="time_slots.monday && time_slots.thursday.length">
                                    <div class="badge badge-pill badge-primary" data-toggle="modal"
                                         data-target=".bd-example-modal-lg" v-for="data in time_slots.thursday"
                                         v-on:click="showDetail(data)">@{{ formatData(data) }}
                                    </div>
                                </div>
                                <div v-else>
                                    No record found
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Friday</th>
                            <td colspan="3">
                                <div v-if="time_slots.monday && time_slots.friday.length">
                                    <div class="badge badge-pill badge-primary" data-toggle="modal"
                                         data-target=".bd-example-modal-lg" v-for="data in time_slots.friday"
                                         v-on:click="showDetail(data)">@{{ formatData(data) }}
                                    </div>
                                </div>
                                <div v-else>
                                    No record found
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Saturday</th>
                            <td colspan="3">
                                <div v-if="time_slots.monday && time_slots.saturday.length">
                                    <div class="badge badge-pill badge-primary" data-toggle="modal"
                                         data-target=".bd-example-modal-lg" v-for="data in time_slots.saturday"
                                         v-on:click="showDetail(data)">@{{ formatData(data) }}
                                    </div>
                                </div>
                                <div v-else>
                                    No record found
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Sunday</th>
                            <td colspan="3">
                                <div v-if="time_slots.monday && time_slots.sunday.length">
                                    <div class="badge badge-pill badge-primary" data-toggle="modal"
                                         data-target=".bd-example-modal-lg" v-for="data in time_slots.sunday"
                                         v-on:click="showDetail(data)">@{{ formatData(data) }}
                                    </div>
                                </div>
                                <div v-else>
                                    No record found
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal fade bd-example-modal-lg" ref="slot_modal" tabindex="-1" role="dialog"
                     aria-labelledby="myLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content p-5">
                            <h6 class="heading-small text-muted mb-4" v-if="form.is_add">Add New Slot</h6>
                            <h6 class="heading-small text-muted mb-4" v-if="!form.is_add">Update Slot</h6>
                            <form v-on:submit.prevent="submitForm">
                                @csrf
                                <div class="alert alert-danger" v-if="is_error_thrown" v-cloak>
                                    <ul>
                                        <li v-for="message in messages">@{{ message.message }}</li>
                                    </ul>
                                </div>
                                <div class="alert alert-success alert-block" v-if="data_success" v-cloak>
                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                    <strong>@{{ success_message }}</strong>
                                </div>
                                <div class="col col-lg-12">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group focused">
                                                <label class="form-control-label" for="input-day">Day</label>
                                                <select class="form-control" id="day"
                                                        name="day" autocomplete="day" v-model="form.day"
                                                        :disabled="!form.is_add">
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
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-control-label" for="input-start-time">Start
                                                    Time</label>
                                                <div class="form-control timepicker">
                                                    <input class="time-picker start-time"
                                                           id="start-time" width="276" name="start-time"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col col-lg-12">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-control-label" for="input-end-time">End Time</label>
                                                <div class="form-control timepicker">
                                                    <input class="time-picker end-time" id="end-time"
                                                            width="276" name="end-time"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-control-label" for="input-treatment-type">Treatment
                                                    Type</label>
                                                <select class="form-control"
                                                        id="treatment_type"
                                                        name="treatment_type" autocomplete="treatment_type"
                                                        v-model="form.treatment_type">
                                                    <option value="1">Video call</option>
                                                    <option value="2">In Clinic</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @if(!$is_doctor)
                                    <div class="col col-lg-12">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="form-control-label" for="input-rate">Fee Rate</label>
                                                    <input type="text" id="rate" name="rate"
                                                           class="form-control form-control-alternative"
                                                           v-model="form.rate"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <div class="col col-lg-12">
                                    <div class="row">
                                        <div class="col-4">
                                            <button type="submit" class="btn btn-sm btn-primary">
                                                @{{ form.form_type }}
                                            </button>
                                            <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">
                                                Close
                                            </button>
                                        </div>
                                        <div class="col-8">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection