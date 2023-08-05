<div>
    <h6>{{ trans('labels.change_phone') }}</h6>
    @if (!customer()->phone_verified)
        <div class="alert alert-warning mb-3" role="alert">
            Số điện thoại của quý khách chưa được xác nhận, vui lòng xác nhận số điện thoại để tiến hành mua hàng cũng như chức năng khác!
        </div>
    @endif
    <div class="row mb-2">
        <div class="col-12 col-lg-6">
            <label>{{ trans('labels.phone') }} *</label>
            {!! Form::text('phone', null, ['class' => 'form-control', 'required', 'wire:model.lazy' => 'phone']) !!}
            @error('phone')
                <span class="error">{{ $message }}</span>
            @enderror
        </div><!-- End .col-sm-6 -->
        <div class="col-12 col-lg-6">
            <label>{{ trans('labels.otp') }} *</label>
            <div class="position-relative mb-1">
                {!! Form::text('otp', null, ['class' => 'form-control mb-0', 'wire:model.lazy' => 'otp']) !!}
                <a class="d-flex align-items-center" href="#" id="sendOtpBtn"
                    style="position: absolute;
                            top: 50%;
                            right: 0;
                            transform: translate(-10%, -50%);}">
                    <div wire:loading wire:target="sendVerify" class="spinner-border spinner-border-sm mr-1"
                        role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                    {{ trans('labels.send_otp') }}
                </a>
            </div>
            @if (!empty($errorMessage))
                <span class="error">{{ $errorMessage }}</span>
            @endif
            @error('otp')
                <span class="error">{{ $message }}</span>
            @enderror
            <div id="recaptcha-container" wire:ignore></div>
        </div><!-- End .col-sm-6 -->
    </div>
    <div class="text-right">
        <button wire:click="returnToProfile" class="btn btn-outline-primary-2 mr-3">
            <div wire:loading wire:target="returnToProfile" class="spinner-grow" style="width: 3rem; height: 3rem;"
                role="status">
                <span class="sr-only">Loading...</span>
            </div>
            <i class="fas fa-undo mr-3"></i>
            {{ trans('labels.return') }}
        </button>
        <button class="update-phone-btn btn btn-outline-primary-2" @disabled(empty($phone))>
            <div wire:loading wire:target="updatePhone" class="spinner-grow" style="width: 3rem; height: 3rem;"
                role="status">
                <span class="sr-only">Loading...</span>
            </div>
            {{ trans('labels.update') }}
            <i class="icon-long-arrow-right"></i>
        </button>
    </div>
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
            $('body').on('click', '#sendOtpBtn', async (e) => {
                e.preventDefault();
                var appVerifier = window.recaptchaVerifier;
                const response = await signInWithPhoneNumber(auth, `+84${$('[name=phone]').val()}`, appVerifier);
            })
            @this.on('verifyPhone', (event) => {
            signInWithPhoneNumber(auth, `+84${$('input[name=phone]').val()}`, window.recaptchaVerifier)
                .then((confirmationResult) => {
                    window.confirmationResult = confirmationResult;
                    sessionInfo = confirmationResult.verificationId
                    @this.verified = true;
                }).catch((error) => {
                    @this.errorMessage = debugErrorMap()[error.code.replace('auth/', '')]
                });
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
