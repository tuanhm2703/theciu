<div>
    {!! Form::open([
        'url' => route('client.auth.register'),
        'method' => 'POST',
        'id' => 'register-form',
    ]) !!}
    <div class="row">
        <div class="form-group col-12 col-md-6">
            {!! Form::label('register_first_name', trans('labels.first_name') . '*', []) !!}
            {!! Form::text('register_first_name', null, [
                'class' => 'form-control',
                'required',
                'wire:model.lazy' => 'first_name',
            ]) !!}
            @error('first_name')
                <div class="mt-1">
                    <span class="text-danger">{{ $message }}</span>
                </div>
            @enderror
        </div><!-- End .form-group -->
        <div class="form-group col-12 col-md-6">
            {!! Form::label('register_last_name', trans('labels.last_name') . '*', []) !!}
            {!! Form::text('register_last_name', null, [
                'class' => 'form-control',
                'required',
                'wire:model.lazy' => 'last_name',
            ]) !!}
            @error('last_name')
                <div class="mt-1">
                    <span class="text-danger">{{ $message }}</span>
                </div>
            @enderror
        </div><!-- End .form-group -->
    </div>
    <div class="form-group">
        {!! Form::label('register_email', trans('labels.email_address') . '*', []) !!}
        {!! Form::email('register_email', null, ['class' => 'form-control', 'required', 'wire:model.lazy' => 'email']) !!}
        @error('email')
            <div class="mt-1">
                <span class="text-danger">{{ $message }}</span>
            </div>
        @enderror
    </div><!-- End .form-group -->
    <div class="form-group">
        {!! Form::label('register_phone', trans('labels.phone') . '*', []) !!}
        {!! Form::text('register_phone', null, ['class' => 'form-control', 'required', 'wire:model.lazy' => 'phone']) !!}
        @error('phone')
            <div class="mt-1">
                <span class="text-danger">{{ $message }}</span>
            </div>
        @enderror
    </div><!-- End .form-group -->
    <div class="form-group">
        {!! Form::label('register_password', trans('labels.password') . '*', []) !!}
        {!! Form::password('register_password', [
            'class' => 'form-control',
            'required',
            'wire:model.lazy' => 'password',
        ]) !!}
        @error('password')
            <div class="mt-1">
                <span class="text-danger">{{ $message }}</span>
            </div>
        @enderror
    </div><!-- End .form-group -->
    <div class="form-group">
        {!! Form::label('register_password_confirmation', trans('labels.password_confirmation') . '*', []) !!}
        {!! Form::password('register_password_confirmation', [
            'class' => 'form-control',
            'required',
            'wire:model.lazy' => 'password_confirmation',
        ]) !!}
        <div id="recaptcha-container" wire:ignore></div>
    </div><!-- End .form-group -->
    <div class="form-group">
        {!! Form::label('register_otp', 'Mã xác nhận' . '*', []) !!}
        <div class="position-relative mb-1">
            {!! Form::text('register_otp', null, ['class' => 'form-control mb-0', 'wire:model.lazy' => 'otp']) !!}
            <a class="d-flex align-items-center" href="#" id="sendRegisterOtpBtn"
                style="position: absolute;
                            top: 50%;
                            right: 0;
                            transform: translate(-10%, -50%);}">
                <div wire:loading wire:target="sendVerify" class="spinner-border spinner-border-sm mr-1" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
                {{ trans('labels.send_otp') }}
            </a>
        </div>
        @error('otp')
            <div class="mt-1">
                <span class="text-danger">{{ $message }}</span>
            </div>
        @enderror
        @if ($this->errorMessage)
            <div class="mt-1">
                <span class="text-danger">{{ $this->errorMessage }}</span>
            </div>
        @endif
    </div>
    <div class="form-footer border-bottom-0">
        <button type="button" wire:click.prevent="register" class="btn btn-outline-primary-2">
            <span wire:loading wire:target="register" class="spinner-border spinner-border-sm mr-3" role="status"
                aria-hidden="true"></span>
            <span wire:loading.remove wire:target="register">{{ trans('labels.signin') }}<i
                    class="icon-long-arrow-right"></i></span>
        </button>

        <a href="#" class="forgot-link">{{ trans('labels.forgot_password') }} ?</a>
    </div><!-- End .form-footer -->
    {!! Form::close() !!}
    <div class="form-choice">
        <p class="text-center">{{ trans('labels.or_signin_with') }}</p>
        <div class="row">
            <div class="col-sm-6">
                <a href="{{ route('client.auth.google.login') }}" class="btn btn-login btn-g">
                    <i class="icon-google"></i>
                    {{ trans('labels.login_with_google') }}
                </a>
            </div><!-- End .col-6 -->
            <div class="col-sm-6">
                <a href="{{ route('client.auth.facebook.login') }}" class="btn btn-login btn-f">
                    <i class="icon-facebook-f"></i>
                    {{ trans('labels.login_with_facebook') }}
                </a>
            </div><!-- End .col-6 -->
        </div><!-- End .row -->
    </div><!-- End .form-choice -->
</div>
@push('js')
    <script type="module">
        // Import the functions you need from the SDKs you need
        import {
            initializeApp
        } from "https://www.gstatic.com/firebasejs/9.18.0/firebase-app.js";
        import {
            getAnalytics
        } from "https://www.gstatic.com/firebasejs/9.18.0/firebase-analytics.js";
        import {
            getAuth,
            RecaptchaVerifier,
            signInWithPhoneNumber,
            debugErrorMap
        } from "https://www.gstatic.com/firebasejs/9.18.0/firebase-auth.js";
        document.addEventListener('livewire:load', function() {
            const firebaseConfig = {
                apiKey: "AIzaSyAdswi_EUpzO0_Q2QTksJ7j65M26KsZMg4",
                authDomain: "the-ciu.firebaseapp.com",
                projectId: "the-ciu",
                storageBucket: "the-ciu.appspot.com",
                messagingSenderId: "54503914857",
                appId: "1:54503914857:web:b49d474c74b68603f7d1f8",
                measurementId: "G-501SNCMP9N"
            };
            // Initialize Firebase
            const app = initializeApp(firebaseConfig);
            const analytics = getAnalytics(app);
            const auth = getAuth();
            let sessionInfo;
            let confirmation;
            let apiKey;

            window.recaptchaVerifier = new RecaptchaVerifier('recaptcha-container', {
                'size': 'invisible',
                'callback': (response) => {
                    const appVerifier = window.recaptchaVerifier;
                    @this.apiKey = appVerifier.auth.config.apiKey
                    @this.recaptchaToken = response
                    @this.errorMessage = ''
                    @this.sendVerify();
                },
            }, auth);
            recaptchaVerifier.render().then((widgetId) => {
                window.recaptchaWidgetId = widgetId;
            });
            $('body').on('click', '#sendRegisterOtpBtn', async (e) => {
                e.preventDefault();
                const response = await signInWithPhoneNumber(auth, '+84' + $('[name=phone]').val(),
                    window.recaptchaVerifier);
            })
            $('#forgot-password-form').on('submit', (e) => {
                e.preventDefault()
                $('#submitBtn').click();
            });
            $('body').on('click', '.update-phone-btn', (e) => {
                @this.updatePhone($('[name=otp]').val())
            })
        })
    </script>
@endpush
