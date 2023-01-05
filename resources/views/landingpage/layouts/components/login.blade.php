<div class="tab-content" id="tab-content-5">
    <div class="tab-pane fade show active" id="signin" role="tabpanel"
        aria-labelledby="signin-tab">
        {!! Form::open([
            'url' => route('client.auth.login'),
            'method' => 'POST',
        ]) !!}
        <div class="form-group">
            {!! Form::label('username', trans('labels.phone_or_email') . '*', []) !!}
            {!! Form::text('username', null, ['class' => 'form-control', 'id' => 'signin-email', 'required']) !!}
        </div><!-- End .form-group -->

        <div class="form-group">
            {!! Form::label('password', trans('labels.password') . '*', []) !!}
            {!! Form::password('password', ['class' => 'form-control', 'id' => 'signin-password', 'required']) !!}
        </div><!-- End .form-group -->

        <div class="form-footer">
            <button type="submit" class="btn btn-outline-primary-2">
                <span>LOG IN</span>
                <i class="icon-long-arrow-right"></i>
            </button>

            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" id="signin-remember">
                <label class="custom-control-label" for="signin-remember">Remember
                    Me</label>
            </div><!-- End .custom-checkbox -->

            <a href="#" class="forgot-link">{{ trans('labels.forgot_password') }}
                ?</a>
        </div><!-- End .form-footer -->
        {!! Form::close() !!}
        <div class="form-choice">
            <p class="text-center">{{ trans('labels.or_signin_with') }}</p>
            <div class="row">
                <div class="col-sm-6">
                    <a href="#" class="btn btn-login btn-g">
                        <i class="icon-google"></i>
                        Login With Google
                    </a>
                </div><!-- End .col-6 -->
                <div class="col-sm-6">
                    <a href="#" class="btn btn-login btn-f">
                        <i class="icon-facebook-f"></i>
                        Login With Facebook
                    </a>
                </div><!-- End .col-6 -->
            </div><!-- End .row -->
        </div><!-- End .form-choice -->
    </div><!-- .End .tab-pane -->
    <div class="tab-pane fade" id="register" role="tabpanel"
        aria-labelledby="register-tab">
        <form action="#">
            <div class="form-group">
                <label for="register-email">Your email address *</label>
                <input type="email" class="form-control" id="register-email"
                    name="register-email" required>
            </div><!-- End .form-group -->

            <div class="form-group">
                <label for="register-password">Password *</label>
                <input type="password" class="form-control" id="register-password"
                    name="register-password" required>
            </div><!-- End .form-group -->

            <div class="form-footer">
                <button type="submit" class="btn btn-outline-primary-2">
                    <span>SIGN UP</span>
                    <i class="icon-long-arrow-right"></i>
                </button>

                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input"
                        id="register-policy" required>
                    <label class="custom-control-label" for="register-policy">I agree to
                        the <a href="#">privacy policy</a> *</label>
                </div><!-- End .custom-checkbox -->
            </div><!-- End .form-footer -->
        </form>
        <div class="form-choice">
            <p class="text-center">or sign in with</p>
            <div class="row">
                <div class="col-sm-6">
                    <a href="#" class="btn btn-login btn-g">
                        <i class="icon-google"></i>
                        Login With Google
                    </a>
                </div><!-- End .col-6 -->
                <div class="col-sm-6">
                    <a href="#" class="btn btn-login  btn-f">
                        <i class="icon-facebook-f"></i>
                        Login With Facebook
                    </a>
                </div><!-- End .col-6 -->
            </div><!-- End .row -->
        </div><!-- End .form-choice -->
    </div><!-- .End .tab-pane -->
</div><!-- End .tab-content -->
