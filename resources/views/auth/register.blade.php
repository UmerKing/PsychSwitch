@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">{{ __('Complete the Registration below to use Psychswitch features') }}
                    </div>

                    <div class="card-body" id="register-card">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            <div class="form-group row">
                                <label for="registered-as"
                                       class="col-md-2 col-form-label text-md-left">{{ __('Registered As') }}</label>

                                <div class="col-md-4">
                                    <select class="form-control" id="registered-as" name="registered-as"
                                            v-on:click="switchForm">
                                        <option value="1">Patient</option>
                                        <option value="2">Doctor</option>
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
                                    <input id="city_id" type="text" placeholder="Your City"
                                           class="form-control @error('city_id') is-invalid @enderror" name="city_id"
                                           value="{{ old('city_id') }}" required autocomplete="city_id">

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
                                </div>
                            </div>

                            <div class="form-group row doctor-info-row" v-if="seen">
                                <label for="designation"
                                       class="col-md-2 col-form-label text-md-left">{{ __('Designation') }}</label>

                                <div class="col-md-4">
                                    <input id="designation" type="text" placeholder="Your Designation"
                                           class="form-control @error('designation') is-invalid @enderror"
                                           name="designation" autocomplete="designation">
                                </div>
                                <label for="speciality"
                                       class="col-md-2 col-form-label text-md-left">{{ __('Speciality') }}</label>

                                <div class="col-md-4">
                                    <input id="speciality" type="text" placeholder="Your Speciality"
                                           class="form-control" name="speciality" autocomplete="speciality">
                                </div>
                            </div>

                            <div class="form-group row" v-if="seen">
                                <label for="pmdc" class="col-md-2 col-form-label text-md-left">{{ __('PMDC#') }}</label>

                                <div class="col-md-4">
                                    <input id="pmdc" placeholder="Your PMDC" type="text" class="form-control"
                                           name="pmdc" autocomplete="pmdc">
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
