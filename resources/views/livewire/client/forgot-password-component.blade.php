<div class="w-100">
    {!! Form::open([
        'id' => 'forgot-password-form',
        'class' => 'p-5',
    ]) !!}
    @if (!$verified && !$mailSent)
        <div class="form-group">
            {!! Form::label('username', trans('labels.phone_or_email') . '*', []) !!}
            {!! Form::text('username', null, ['class' => 'form-control', 'required', 'wire:model.lazy' => 'username']) !!}
            @error('username')
                <div class="pt-1"><span class="text-danger mt-3">{{ $message }}</span></div>
            @enderror
            @if (!empty($errorMessage))
            <div class="mt-1"><i class="text-danger">{{ $errorMessage }}</i></div>
            @endif

        </div><!-- End .form-group -->

        <div id="recaptcha-container"></div>
        <div class="form-footer text-right">
            <button type="button" id="submitBtn" class="btn btn-outline-primary-2">
                <span>{{ trans('labels.next') }}</span>
                <i class="icon-long-arrow-right"></i>
            </button>
        </div><!-- End .form-footer -->
    @elseif(!$mailSent)
        <div class="form-group">
            {!! Form::label('otp', trans('labels.verification_code') . '*', []) !!}
            {!! Form::number('otp', null, ['class' => 'form-control', 'required', 'wire:model.lazy' => 'otp']) !!}
            @if (!empty($errorMessage))
                <div class="mt-3"><i class="text-danger">{{ $errorMessage }}</i></div>
            @endif
        </div><!-- End .form-group -->
        <div class="form-footer text-right">
            <button type="submit" id="verifyOtpBtn" class="btn btn-outline-primary-2">
                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" wire:loading
                    wire:target="verifyOtp, sendVerify"></span>
                <span>{{ trans('labels.next') }}</span>
                <i class="icon-long-arrow-right"></i>
            </button>
        </div><!-- End .form-footer -->
    @endif
    @if ($mailSent)
        <div>
            <p>Chúng tôi đã gửi thông tin lấy lại mật khẩu đến Email của bạn, vui lòng kiểm tra lại hộp thư.</p>
            <a wire.click.prevent="sendVerify" class="d-block text-right" href="#">Chưa nhận được email? Gửi
                lại.</a>
        </div>
    @endif
    {!! Form::close() !!}
</div>
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
        document.addEventListener('livewire:load', function () {
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
            'size': 'normal',
            'callback': (response) => {
                const appVerifier = window.recaptchaVerifier;
                @this.apiKey = appVerifier.auth.config.apiKey
                @this.recaptchaToken = response
                @this.errorMessage = ''
                @this.sendVerify();
            },
        }, auth);

        $('body').on('click', '#verifyOtpBtn', (e) => {
            @this.verifyOtp($('input[name=otp]').val(), apiKey, sessionInfo)
        })

        $('#submitBtn').on('click', (e) => {
            e.preventDefault();
            console.log(window.recaptchaWidgetId);
            if(window.recaptchaWidgetId != null) {
                @this.sendVerify();
            } else {
                recaptchaVerifier.render().then((widgetId) => {
                window.recaptchaWidgetId = widgetId;
            });
            }
        })
        @this.on('verifyPhone', (event) => {
        signInWithPhoneNumber(auth, `+84${$('input[name=username]').val()}`, window.recaptchaVerifier)
            .then((confirmationResult) => {
                window.confirmationResult = confirmationResult;
                sessionInfo = confirmationResult.verificationId
                @this.verified = true;
            }).catch((error) => {
                @this.errorMessage = debugErrorMap()[error.code.replace('auth/', '')]
            });
        })
    })


</script>
