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

        <div id="recaptcha-forgot-container"></div>
        <div class="form-footer text-right">
            <button type="button" id="submitForgotBtn" class="btn btn-outline-primary-2">
                <span wire:loading wire:target="sendVerify" class="spinner-border spinner-border-sm mr-3" role="status"
                    aria-hidden="true"></span>
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
            <button type="button" id="verifyForgotPasswordOtpBtn" class="btn btn-outline-primary-2">
                <span wire:loading wire:target="verifyOtp, sendVerify" class="spinner-border spinner-border-sm mr-3"
                    role="status" aria-hidden="true"></span>
                <span>{{ trans('labels.next') }}</span>
                <i class="icon-long-arrow-right"></i>
            </button>
        </div><!-- End .form-footer -->
    @endif
    @if ($mailSent)
        <div>
            <p>Chúng tôi đã gửi thông tin lấy lại mật khẩu đến Email của bạn, vui lòng kiểm tra lại hộp thư.</p>
            <a wire:click.prevent="sendVerify" class="d-block text-right" href="#">Chưa nhận được email? Gửi
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
    $('[href="#signin-modal"]').attr('data-toggle', '')
    document.addEventListener('livewire:load', function() {
        (async () => {
            $('[href="#signin-modal"]').on('click', (e) => {
                e.preventDefault()
                window.location.href = `{{ route('client.home', ['authenticated' => '0']) }}`
            })
            const firebaseConfig = @json(config('app.firebase'))
            // Initialize Firebase
            const app = initializeApp(firebaseConfig);
            const analytics = getAnalytics(app);
            const auth = getAuth();
            let sessionInfo;
            let confirmation;
            let apiKey;

            function isValidEmail(email) {
                var emailRegex = /^[\w-]+(\.[\w-]+)*@([\w-]+\.)+[a-zA-Z]{2,7}$/;
                return emailRegex.test(email);
            }

            $('body').on('click', '#verifyForgotPasswordOtpBtn', (e) => {
                @this.verifyOtp($('input[name=otp]').val(), apiKey, sessionInfo)
            })

            $('#submitForgotBtn').on('click', async (e) => {
                e.preventDefault();
                if (!isValidEmail($('[name=username]').val())) {
                    if (window.recaptchaVerifier) {
                        window.recaptchaVerifier?.recaptcha?.reset()
                    } else {
                        window.recaptchaVerifier = new RecaptchaVerifier(
                            'recaptcha-forgot-container', {
                                'size': 'invisible',
                                'callback': (response) => {
                                    @this.apiKey = window.recaptchaVerifier.auth
                                        .config
                                        .apiKey
                                    @this.recaptchaToken = response
                                    @this.errorMessage = ''
                                    @this.sendVerify();
                                },
                            }, auth);
                    }
                    await window.recaptchaVerifier.render().then((widgetId) => {
                        window.recaptchaWidgetId = widgetId;
                        window.recaptchaVerifier.verify()
                    });
                } else {
                    @this.sendVerify();
                }
            })
            $('#forgot-password-form').on('submit', (e) => {
                e.preventDefault()
                $('#submitForgotBtn').click();
            });
        })()
    })
</script>
