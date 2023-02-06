<div class="tab-content" id="tab-content-5">
    <div class="tab-pane fade show active" id="signin" role="tabpanel" aria-labelledby="signin-tab">
        {!! Form::open([
            'url' => route('client.auth.login'),
            'method' => 'POST',
            'id' => 'login-form',
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
                    <a href="{{ route('client.auth.google.login') }}" class="btn btn-login btn-g">
                        <i class="icon-google"></i>
                        Login With Google
                    </a>
                </div><!-- End .col-6 -->
                <div class="col-sm-6">
                    <a href="{{ route('client.auth.facebook.login') }}" class="btn btn-login btn-f">
                        <i class="icon-facebook-f"></i>
                        Login With Facebook
                    </a>
                </div><!-- End .col-6 -->
            </div><!-- End .row -->
        </div><!-- End .form-choice -->
    </div><!-- .End .tab-pane -->
    <div class="tab-pane fade" id="register" role="tabpanel" aria-labelledby="register-tab">
        {!! Form::open([
            'url' => route('client.auth.register'),
            'method' => 'POST',
            'id' => 'register-form',
        ]) !!}
        <div class="form-group">
            {!! Form::label('username', trans('labels.phone_or_email') . '*', []) !!}
            {!! Form::text('username', null, ['class' => 'form-control', 'id' => 'signin-email', 'required']) !!}
        </div><!-- End .form-group -->

        <div class="form-group">
            {!! Form::label('password', trans('labels.password') . '*', []) !!}
            {!! Form::password('password', ['class' => 'form-control', 'id' => 'signin-password', 'required']) !!}
        </div><!-- End .form-group -->
        <div class="form-group">
            {!! Form::label('password_confirmation', trans('labels.password_confirmation') . '*', []) !!}
            {!! Form::password('password_confirmation', ['class' => 'form-control', 'id' => 'signin-password', 'required']) !!}
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
            <p class="text-center">or sign in with</p>
            <div class="row">
                <div class="col-sm-6">
                    <a href="{{ route('client.auth.google.login') }}" class="btn btn-login btn-g">
                        <i class="icon-google"></i>
                        Login With Google
                    </a>
                </div><!-- End .col-6 -->
                <div class="col-sm-6">
                    <a href="{{ route('client.auth.facebook.login') }}" class="btn btn-login btn-f">
                        <i class="icon-facebook-f"></i>
                        Login With Facebook
                    </a>
                </div><!-- End .col-6 -->
            </div><!-- End .row -->
        </div><!-- End .form-choice -->
    </div><!-- .End .tab-pane -->
</div><!-- End .tab-content -->
