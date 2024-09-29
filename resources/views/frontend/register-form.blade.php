<div class="offset-xxl-2 offset-xl-1 col-lg-6 col-xxl-5">
<div class="card">
    <div class="card-body">
        <div class="mb-4 text-center">
            <!-- <h2 class="h3 text-primary mb-0">{{ translate('Create Your Account') }}</h2> -->
            <h4 class="h3 text-primary mb-0">{{ translate('100% Free Registration -Create a Marriage Profile') }}</h4>
            <p>{{ translate('Fill out the form to get started') }}.</p>
        </div>
        <form class="form-default" id="reg-form" role="form"
            action="{{ route('register') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group mb-3">
                        <label class="form-label"
                            for="on_behalf">{{ translate('Name of Person') }}</label>
                        @php $on_behalves = \App\Models\OnBehalf::all(); @endphp
                        <select
                            class="form-control aiz-selectpicker @error('on_behalf') is-invalid @enderror"
                            name="on_behalf" >
                            @foreach ($on_behalves as $on_behalf)
                                <option value="{{ $on_behalf->id }}">{{ $on_behalf->name }}
                                </option>
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
                            placeholder="{{ translate('First Name') }}" >
                        @error('first_name')
                            <span class="invalid-feedback"
                                role="alert">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group mb-3">
                        <label class="form-label"
                            for="name">{{ translate('Surname') }}</label>
                        <input type="text"
                            class="form-control @error('last_name') is-invalid @enderror"
                            name="last_name" id="last_name"
                            placeholder="{{ translate('Last Name') }}" >
                        @error('last_name')
                            <span class="invalid-feedback"
                                role="alert">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group mb-3">
                        <label class="form-label"
                            for="gender">{{ translate('Gender') }}</label>
                        <select
                            class="form-control aiz-selectpicker @error('gender') is-invalid @enderror"
                            name="gender" >
                            <option value="1">{{ translate('Male') }}</option>
                            <option value="2">{{ translate('Female') }}</option>
                        </select>
                        @error('gender')
                            <span class="invalid-feedback"
                                role="alert">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="first_name">{{ translate('Marital  Status') }}
                        <span class="text-danger">*</span>
                    </label>
                    <select class="form-control aiz-selectpicker" id="marital_status"
                        name="marital_status" data-live-search="true" >
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
                            autocomplete="off" >
                        @error('date_of_birth')
                            <span class="invalid-feedback"
                                role="alert">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group mb-3">
                        <label class="form-label"
                            for="education">{{ translate('Education') }}</label>
                        <input type="text" class="form-control" name="education"
                            id="education" placeholder="{{ translate(' Enter Education') }}">
                       @error('education')
                           	<span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group mb-3">
                        <label class="form-label"
                            for="profession">{{ translate('Profession') }}</label>
                        <input type="text" class="form-control " name="profession"
                            id="profession" placeholder="{{ translate('Enter Profession') }}">
                        @error('profession')
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group mb-3">
                        <label class="form-label"
                            for="live_city">{{ translate('Live in city') }}</label>
                        <input type="text" class="form-control" name="live_city"
                            id="live_city" placeholder="{{ translate('Enter Your City') }}"
                            >
                        @error('live_city')
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <!-- @if (addon_activation('otp_system')) -->
                <div>
                    <div class="d-flex justify-content-between align-items-start">
                        <!-- <label class="form-label"
                            for="email">{{ translate('Email / Phone') }}</label> -->
                        <!-- <button class="btn btn-link p-0 opacity-50 text-reset fs-12"
                            type="button"
                            onclick="toggleEmailPhone(this)">{{ translate('Use Email Instead') }}</button> -->
                    <label class="form-label" for="email">{{ translate('Phone') }}</label>
                    </div>
                    <div class="form-group phone-form-group mb-1">
                        <input type="tel" id="phone-code"
                            class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}"
                            value="{{ old('phone') }}" placeholder="" name="phone"
                            autocomplete="off">
                            @error('phone')
                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                            @enderror
                    </div>
                    <input type="hidden" name="country_code" value="">
                    <div class="form-group email-form-group mb-1">
                    <label class="form-label"
                            for="email">{{ translate('Email') }}</label>
                        <input type="email"
                            class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}"
                            value="{{ old('email') }}"
                            placeholder="{{ translate('Email') }}" name="email"
                            autocomplete="off">
                        @if ($errors->has('email'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
            <!-- @else -->
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
                <!-- <div class="d-flex justify-content-between align-items-start">
                    <label class="form-label" for="email">{{ translate('Phone') }}123</label>
                    <button class="btn btn-link p-0 opacity-50 text-reset fs-12"
                        type="button"
                        onclick="toggleEmailPhone(this)">{{ translate('') }}</button>
                </div> -->
                <!-- <div class="form-group phone-form-group mb-1">
                    <input type="tel"
                        class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}"
                        value="{{ old('phone') }}" name="phone"
                        placeholder="enter phone number" maxlength="10" />
                   <input type="tel" id="phone-code" class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}" value="{{ old('phone') }}" placeholder="" name="phone" autocomplete="off">-->
                <!-- </div> -->
                <!-- <input type="hidden" name="country_code" value=""> -->
            <!-- @endif -->
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group mb-3">
                        <label class="form-label"
                            for="password">{{ translate('Password') }}</label>
                        <input type="password"
                            class="form-control @error('password') is-invalid @enderror"
                            name="password" placeholder="********" aria-label="********"
                            >
                        <small>{{ translate('Minimun 8 characters') }}</small>
                        @error('password')
                            <span class="invalid-feedback"
                                role="alert">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group mb-3">
                        <label class="form-label"
                            for="password-confirm">{{ translate('Confirm password') }}</label>
                        <input type="password" class="form-control"
                            name="password_confirmation" placeholder="********" >
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
                                placeholder="{{ translate('Referral Code') }}"
                                name="referral_code">
                            @if($errors->has('referral_code'))
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
                    <input type="checkbox" name="checkbox_example_1" >
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
            <div class="">
                <button type="submit"
                    class="btn btn-block btn-primary">{{ translate('Create Account') }}</button>
            </div>
            @if (get_setting('google_login_activation') == 1 ||
                    get_setting('facebook_login_activation') == 1 ||
                    get_setting('twitter_login_activation') == 1 ||
                    get_setting('apple_login_activation') == 1)
                <div class="mt-4">
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
        </form>
    </div>
</div>
</div>
<!-- <script>
document.getElementById('reg-form').addEventListener('submit', function(event) {
    let valid = true;

    // Get form values
    let firstName = document.getElementById('first_name').value;
    let lastName = document.getElementById('last_name').value;
    let gender = document.querySelector('select[name="gender"]').value;
    let maritalStatus = document.querySelector('select[name="marital_status"]').value;
    let dateOfBirth = document.getElementById('date_of_birth').value;
    let education = document.getElementById('education').value;
    let profession = document.getElementById('profession').value;
    let liveCity = document.getElementById('live_city').value;
    let phone = document.getElementById('phone-code').value;
    let email = document.querySelector('input[name="email"]').value;
    let password = document.querySelector('input[name="password"]').value;
    let passwordConfirmation = document.querySelector('input[name="password_confirmation"]').value;

    // Simple validation checks
    if (firstName === '' || lastName === '' || gender === '' || maritalStatus === '' || dateOfBirth === '' || education === '' || profession === '' || liveCity === '' || phone === '' || email === '' || password === '' || password !== passwordConfirmation) {
        valid = false;
        alert('Please fill in all required fields and ensure passwords match.');
    }

    // If invalid, prevent the form submission
    if (!valid) {
        event.preventDefault();
    }
});
</script> -->