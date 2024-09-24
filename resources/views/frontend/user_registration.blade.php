@extends('frontend.layouts.app')



<style>

    .input-group>.intl-tel-input.allow-dropdown {

        -webkit-box-flex: 1;

        -ms-flex: 1 1 auto;

        flex: 1 1 auto;

        width: 1%;

    }



    .input-group>.intl-tel-input.allow-dropdown>.flag-container {

        z-index: 4;

    }



    .iti-flag {

        background-image: url("https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/12.1.6/img/flags.png");

    }



    /*s */

    select option {

        background-color: white;

        border: 1px solid pink;

        color: black;

        /* Optional: Set text color for better contrast */

    }



    select option:hover {



        background-color: pink;



    }



    #phone-code,

    .btn {

        padding-top: 6px;

        padding-bottom: 6px;

        border: 1px solid #ccc;

        border-radius: 4px;

    }



    .btn {

        color: #ffffff;

        background-color: #428BCA;

        border-color: #357EBD;

        font-size: 14px;

        outline: none;

        cursor: pointer;

        padding-left: 12px;

        padding-right: 12px;

    }



    .btn:focus,

    .btn:hover {

        background-color: #3276B1;

        border-color: #285E8E;

    }



    .btn:active {

        box-shadow: inset 0 3px 5px rgba(0, 0, 0, .125);

    }



    .alert {

        padding: 15px;

        margin-top: 10px;

        border: 1px solid transparent;

        border-radius: 4px;

    }



    .alert-info {

        border-color: #bce8f1;

        color: #31708f;

        background-color: #d9edf7;

    }



    .alert-error {

        color: #a94442;

        background-color: #f2dede;

        border-color: #ebccd1;

    }



    /*end */

</style>

@section('content')

    <div class="py-4 py-lg-5">

        <div class="container">

            <div class="row">

                <div class="col-xxl-6 col-xl-6 col-md-8 mx-auto">

                    <div class="card">

                        <div class="card-body">



                            <div class="mb-5 text-center">

                                <h1 class="h5 text-primary mb-0">

                                    {{ translate('100% free Registration - Create a Marriage Profile') }}</h1>

                                <p>{{ translate('Fill out the form to get started') }}.</p>

                            </div>

                            <form class="form-default" id="reg-form" role="form" action="{{ route('register') }}"

                                method="POST">

                                @csrf

                                <div class="row">

                                    <div class="col-lg-12">

                                        <div class="form-group mb-3">

                                            <label class="form-label"

                                                for="on_behalf">{{ translate('Name of Person ') }}</label>

                                            @php $on_behalves = \App\Models\OnBehalf::all(); @endphp

                                            <select

                                                class="form-control aiz-selectpicker @error('on_behalf') is-invalid @enderror"

                                                name="on_behalf" required>

                                                @foreach ($on_behalves as $on_behalf)

                                                    <option value="{{ $on_behalf->id }}">{{ $on_behalf->name }}</option>

                                                @endforeach

                                            </select>

                                            @error('on_behalf')

                                                <span class="invalid-feedback" role="alert">{{ $message }}</span>

                                            @enderror

                                        </div>

                                    </div>

                                </div>

                                <div class="row">

                                    <div class="col-lg-6">

                                        <div class="form-group mb-3">

                                            <label class="form-label"

                                                for="name">{{ translate('Groom/Bride name') }}</label>

                                            <input type="text"

                                                class="form-control @error('first_name') is-invalid @enderror"

                                                name="first_name" id="first_name"

                                                placeholder="{{ translate('Enter Groom/Bride name') }}" required>

                                            @error('first_name')

                                                <span class="invalid-feedback" role="alert">{{ $message }}</span>

                                            @enderror

                                        </div>

                                    </div>

                                    <div class="col-lg-6">

                                        <div class="form-group mb-3">

                                            <label class="form-label" for="name">{{ translate('Surname') }}</label>

                                            <input type="text"

                                                class="form-control @error('last_name') is-invalid @enderror"

                                                name="last_name" id="last_name" placeholder="{{ translate('Surname') }}"

                                                required>

                                            @error('last_name')

                                                <span class="invalid-feedback" role="alert">{{ $message }}</span>

                                            @enderror

                                        </div>

                                    </div>

                                </div>

                                <div class="row">

                                    <div class="col-lg-6">

                                        <div class="form-group mb-3">

                                            <label class="form-label" for="gender">{{ translate('Gender') }}</label>

                                            <select

                                                class="form-control aiz-selectpicker @error('gender') is-invalid @enderror"

                                                name="gender" required>

                                                <option value="1">{{ translate('Male') }}</option>

                                                <option value="2">{{ translate('Female') }}</option>

                                            </select>

                                            @error('gender')

                                                <span class="invalid-feedback" role="alert">{{ $message }}</span>

                                            @enderror

                                        </div>

                                    </div>

                                    <div class="col-md-6">

                                        <label for="first_name">{{ translate('Marital  Status') }}

                                            <span class="text-danger">*</span>

                                        </label>

                                        <select class="form-control aiz-selectpicker" id="marital_status"

                                            name="marital_status" data-live-search="true" required>

                                            @foreach ($marital_statuses as $marital_status)

                                                <option value="{{ $marital_status->id }}">

                                                    {{ $marital_status->name }}</option>

                                            @endforeach

                                        </select>

                                        @error('marital_status')

                                            <small class="form-text text-danger">{{ $message }}</small>

                                        @enderror

                                    </div>

                                </div>

                                <div class="row">

                                    <div class="col-lg-6">

                                        <div class="form-group mb-3">

                                            <label class="form-label"

                                                for="date_of_birth">{{ translate('Date Of Birth') }}</label>

                                            <input type="date"

                                                class="form-control aiz-date-range @error('date_of_birth') is-invalid @enderror"

                                                name="date_of_birth" id="date_of_birth"

                                                placeholder="{{ translate('Date Of Birth') }}" data-single="true"

                                                data-show-dropdown="true" data-max-date="{{ get_max_date() }}"

                                                autocomplete="off" required>

                                            @error('date_of_birth')

                                                <span class="invalid-feedback" role="alert">{{ $message }}</span>

                                            @enderror

                                        </div>

                                    </div>

                                    <div class="col-lg-6">

                                        <div class="form-group mb-3">

                                            <label class="form-label" for="education">{{ translate('Education') }}</label>

                                            <input type="text" class="form-control" name="education" id="education"

                                                placeholder="{{ translate(' Enter Education') }}" required>

                                        </div>

                                    </div>

                                </div>

                                <div class="row">



                                    <div class="col-lg-6">

                                        <div class="form-group mb-3">

                                            <label class="form-label"

                                                for="profession">{{ translate('Profession') }}</label>

                                            <input type="text" class="form-control " name="profession" id="profession"

                                                placeholder="{{ translate('Enter Profession') }}" required>

                                        </div>

                                    </div>

                                    <div class="col-lg-6">

                                        <div class="form-group mb-3">

                                            <label class="form-label"

                                                for="live_city">{{ translate('Live in city') }}</label>

                                            <input type="text" class="form-control" name="live_city" id="live_city"

                                                placeholder="{{ translate('Enter Your City') }}" required>

                                        </div>

                                    </div>

                                </div>

                                @if (addon_activation('otp_system'))

                                    <div>

                                        <div class="d-flex justify-content-between align-items-start">

                                            <label class="form-label"

                                                for="email">{{ translate('Email / Phone') }}</label>

                                            <button class="btn btn-link p-0 opacity-50 text-reset fs-12" type="button"

                                                onclick="toggleEmailPhone(this)">{{ translate('Use Email Instead') }}</button>

                                        </div>

                                        <div class="form-group phone-form-group mb-1">



                                            <!--									    <input id="phone" type="tel">-->

                                            <!--<span id="valid-msg" class="hide">Valid</span>-->

                                            <!--<span id="error-msg" class="hide">Invalid number</span>-->



                                            <!--<input type="tel" id="phone-code" class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}" value="{{ old('phone') }}" placeholder="" name="phone" autocomplete="off">-->

                                        </div>



                                        <input type="hidden" name="country_code" value="">



                                        <div class="form-group email-form-group mb-1 d-none">

                                            <input type="email"

                                                class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}"

                                                value="{{ old('email') }}" placeholder="{{ translate('Email') }}"

                                                name="email" autocomplete="off">

                                            @if ($errors->has('email'))

                                                <span class="invalid-feedback" role="alert">

                                                    <strong>{{ $errors->first('email') }}</strong>

                                                </span>

                                            @endif

                                        </div>

                                    </div>

                                @else

                                    <div class="form-group phone-form-group mb-1">

                                        

                                    </div>

                                    <div>

                                        <div class="row">

                                            <div class="col-lg-12">



                                                <div class="form-group mb-3">

                                                    <label class="form-label"

                                                        for="email">{{ translate('Email address') }}</label>

                                                    <input type="email"

                                                        class="form-control @error('email') is-invalid @enderror"

                                                        name="email" id="signinSrEmail"

                                                        placeholder="{{ translate('Email Address') }}">

                                                    @error('email')

                                                        <span class="invalid-feedback"

                                                            role="alert">{{ $message }}</span>

                                                    @enderror

                                                </div>

                                            </div>

                                        </div>

                                        <div class="d-flex justify-content-between align-items-start">

                                            <label class="form-label" for="email">{{ translate('Phone') }}</label>

                                            <button class="btn btn-link p-0 opacity-50 text-reset fs-12" type="button"

                                                onclick="toggleEmailPhone(this)">{{ translate('') }}</button>

                                        </div>

                                        <div class="form-group phone-form-group mb-1">

                                            <input type="tel"

                                                class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}"

                                                value="{{ old('phone') }}" name="phone"

                                                placeholder="enter phone number" maxlength="10" />

                                        </div>

                                        <input type="hidden" name="country_code" value="">

                                    </div>

                                @endif

                                <div class="row">

                                    <div class="col-lg-6">

                                        <div class="form-group mb-3">

                                            <label class="form-label" for="password">{{ translate('Password') }}</label>

                                            <input type="password"

                                                class="form-control @error('password') is-invalid @enderror"

                                                name="password" placeholder="********" aria-label="********" required>

                                            <small>{{ translate('Minimun 8 characters') }}</small>

                                            @error('password')

                                                <span class="invalid-feedback" role="alert">{{ $message }}</span>

                                            @enderror

                                        </div>

                                    </div>

                                    <div class="col-lg-6">

                                        <div class="form-group mb-3">

                                            <label class="form-label"

                                                for="password-confirm">{{ translate('Confirm password') }}</label>

                                            <input type="password" class="form-control" name="password_confirmation"

                                                placeholder="********" required>

                                            <small>{{ translate('Minimun 8 characters') }}</small>

                                        </div>

                                    </div>

                                </div>



                                @if (addon_activation('referral_system'))

                                    <div class="row">

                                        <div class="col-lg-12">

                                            <div class="form-group mb-3">

                                                <label class="form-label"

                                                    for="email">{{ translate('Referral Code') }}</label>

                                                <input type="text"

                                                    class="form-control{{ $errors->has('referral_code') ? ' is-invalid' : '' }}"

                                                    value="{{ old('referral_code') }}"

                                                    placeholder="{{ translate('Referral Code') }}" name="referral_code">

                                                @if ($errors->has('referral_code'))

                                                    <span class="invalid-feedback" role="alert">

                                                        <strong>{{ $errors->first('referral_code') }}</strong>

                                                    </span>

                                                @endif

                                            </div>

                                        </div>

                                    </div>

                                @endif



                                @if (get_setting('google_recaptcha_activation') == 1)

                                    <div class="form-group">

                                        <div class="g-recaptcha" data-sitekey="{{ env('CAPTCHA_KEY') }}"></div>

                                        @error('g-recaptcha-response')

                                            <span class="invalid-feedback" role="alert">{{ $message }}</span>

                                        @enderror

                                    </div>

                                @endif



                                <div class="mb-3">

                                    <label class="aiz-checkbox">

                                        <input type="checkbox" name="checkbox_example_1" required>

                                        <span class=opacity-60>{{ translate('By signing up you agree to our') }}

                                            <a href="{{ env('APP_URL') . '/terms-conditions' }}"

                                                target="_blank">{{ translate('terms and conditions') }}.</a>

                                        </span>

                                        <span class="aiz-square-check"></span>

                                    </label>

                                </div>

                                @error('checkbox_example_1')

                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>

                                @enderror



                                <div class="mb-5">

                                    <button type="submit"

                                        class="btn btn-block btn-primary">{{ translate('Create Account') }}</button>

                                </div>

                                @if (get_setting('google_login_activation') == 1 ||

                                        get_setting('facebook_login_activation') == 1 ||

                                        get_setting('twitter_login_activation') == 1 ||

                                        get_setting('apple_login_activation') == 1)

                                    <div class="mb-5">

                                        <div class="separator mb-3">

                                            <span class="bg-white px-3">{{ translate('Or Join With') }}</span>

                                        </div>

                                        <ul class="list-inline social colored text-center">

                                            @if (get_setting('facebook_login_activation') == 1)

                                                <li class="list-inline-item">

                                                    <a href="{{ route('social.login', ['provider' => 'facebook']) }}"

                                                        class="facebook" title="{{ translate('Facebook') }}"><i

                                                            class="lab la-facebook-f"></i></a>

                                                </li>

                                            @endif

                                            @if (get_setting('google_login_activation') == 1)

                                                <li class="list-inline-item">

                                                    <a href="{{ route('social.login', ['provider' => 'google']) }}"

                                                        class="google" title="{{ translate('Google') }}"><i

                                                            class="lab la-google"></i></a>

                                                </li>

                                            @endif

                                            @if (get_setting('twitter_login_activation') == 1)

                                                <li class="list-inline-item">

                                                    <a href="{{ route('social.login', ['provider' => 'twitter']) }}"

                                                        class="twitter" title="{{ translate('Twitter') }}"><i

                                                            class="lab la-twitter"></i></a>

                                                </li>

                                            @endif

                                            @if (get_setting('apple_login_activation') == 1)

                                                <li class="list-inline-item">

                                                    <a href="{{ route('social.login', ['provider' => 'apple']) }}"

                                                        class="apple" title="{{ translate('Apple') }}"><i

                                                            class="lab la-apple"></i></a>

                                                </li>

                                            @endif

                                        </ul>

                                    </div>

                                @endif



                                <div class="text-center">

                                    <p class="text-muted mb-0">{{ translate('Already have an account?') }}</p>

                                    <a href="{{ route('login') }}">{{ translate('Login to your account') }}</a>

                                </div>

                            </form>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

@endsection



@section('script')

    @if (get_setting('google_recaptcha_activation') == 1)

        @include('partials.recaptcha')

    @endif

    @if (addon_activation('otp_system'))

        @include('partials.emailOrPhone')

    @endif

@endsection

