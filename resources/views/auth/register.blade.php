@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">{{ __('Complete the Registration below to use Psychswitch features') }}
                    </div>
                    <div class="card-body" id="register-card">
                        <div class="alert alert-danger" v-if="is_error_thrown" v-cloak>
                            <ul>
                                <li v-for="error in errors">@{{ error.message }}</li>
                            </ul>
                        </div>
                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            <div class="form-group row">
                                <label for="registered-as"
                                       class="col-md-2 col-form-label text-md-left">{{ __('Registered As') }}</label>

                                <div class="col-md-4">
                                    <select class="form-control" id="registered-as" name="registered-as"
                                            v-on:click="switchForm" autocomplete="registered-as">
                                        @if(old('registered-as'))
                                            <option value="{{(int) old('registered-as') == 1 ? 1 : 2}}">{{ (int) old('registered-as') == 1 ? 'Doctor': 'Patient'}}</option>
                                            <option value="{{(int) old('registered-as') == 1 ? 2 : 1}}">{{ (int) old('registered-as') == 1 ? 'Patient': 'Doctor'}}</option>
                                        @else
                                            <option value="1">Doctor</option>
                                            <option value="2">Patient</option>
                                        @endif
                                    </select>

                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="name" class="col-md-2 col-form-label text-md-left">{{ __('Name') }}</label>

                                <div class="col-md-4">
                                    <input id="name" type="text" placeholder="Your Name"
                                           class="form-control @error('name') is-invalid @enderror" name="name"
                                           value="{{ old('name') }}" required autocomplete="name" autofocus>

                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <label for="phone"
                                       class="col-md-2 col-form-label text-md-left">{{ __('Phone') }}</label>

                                <div class="col-md-4">
                                    <input id="phone" type="text" placeholder="Your Phone"
                                           class="form-control @error('phone') is-invalid @enderror" name="phone"
                                           value="{{ old('phone') }}" required autocomplete="phone" autofocus>

                                    @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email"
                                       class="col-md-2 col-form-label text-md-left">{{ __('E-Mail Address') }}</label>

                                <div class="col-md-4">
                                    <input id="email" type="email" placeholder="Your Email"
                                           class="form-control @error('email') is-invalid @enderror" name="email"
                                           value="{{ old('email') }}" required autocomplete="email">

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <label for="city" class="col-md-2 col-form-label text-md-left">{{ __('City') }}</label>

                                <div class="col-md-4">
                                    <select class="form-control @error('city_id') is-invalid @enderror" id="city_id"
                                            name="city_id" autocomplete="city_id" required>
                                        <option v-for="city in cities" v-bind:value="city.id">@{{ city.city }}</option>
                                    </select>

                                    @error('city_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="password"
                                       class="col-md-2 col-form-label text-md-left">{{ __('Password') }}</label>

                                <div class="col-md-4">
                                    <input id="password" type="password" placeholder="Your Password"
                                           class="form-control @error('password') is-invalid @enderror" name="password"
                                           required autocomplete="new-password">

                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <label for="password-confirm"
                                       class="col-md-2 col-form-label text-md-left">{{ __('Confirm Password') }}</label>

                                <div class="col-md-4">
                                    <input id="password-confirm" type="password" placeholder="Re-enter password"
                                           class="form-control" name="password_confirmation" required
                                           autocomplete="new-password">
                                    @error('password_confirmation')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row doctor-info-row" v-if="seen">
                                <label for="designation"
                                       class="col-md-2 col-form-label text-md-left">{{ __('Designation') }}</label>

                                <div class="col-md-4">
                                    <input id="designation" type="text" placeholder="Your Designation"
                                           class="form-control @error('designation') is-invalid @enderror"
                                           name="designation" autocomplete="designation"
                                           value="{{ old('designation') }}" :required="is_required">
                                </div>
                                <label for="speciality"
                                       class="col-md-2 col-form-label text-md-left">{{ __('Speciality') }}</label>

                                <div class="col-md-4">
                                    <select class="form-control" id="speciality_id" name="speciality_id"
                                            autocomplete="speciality_id">
                                        <option value="1" v-for="speciality in specialities"
                                                v-bind:value="speciality.id">@{{ speciality.name }}
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row" v-if="seen">
                                <label for="pmdc" class="col-md-2 col-form-label text-md-left">{{ __('PMDC#') }}</label>

                                <div class="col-md-4">
                                    <input id="pmdc" placeholder="Your PMDC" type="text" class="form-control"
                                           name="pmdc" autocomplete="pmdc" value="{{ old('pmdc') }}"
                                           :required="is_required">
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Register') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
