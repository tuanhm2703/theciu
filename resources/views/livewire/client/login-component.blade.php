<div>
    {!! Form::open([
        'url' => route('client.auth.login'),
        'method' => 'POST',
        'id' => 'login-form',
    ]) !!}
    <div class="form-group">
        {!! Form::label('username', trans('labels.phone_or_email') . '*', []) !!}
        {!! Form::text('username', null, ['class' => 'form-control', 'required', 'wire:model.lazy' => 'username']) !!}
        @error('username')
            <div class="mt-1">
                <span class="text-danger">{{ $message }}</span>
            </div>
        @enderror
    </div><!-- End .form-group -->

    <div class="form-group">
        {!! Form::label('password', trans('labels.password') . '*', []) !!}
        {!! Form::password('password', ['class' => 'form-control', 'required', 'wire:model.lazy' => 'password']) !!}
        @error('password')
            <div class="mt-1">
                <span class="text-danger">{{ $message }}</span>
            </div>
        @enderror
    </div><!-- End .form-group -->

    <div class="form-footer">
        <button type="button" wire:click.prevent="login" class="btn btn-outline-primary-2">
            <span wire:loading wire:target="login" class="spinner-border spinner-border-sm mr-3" role="status" aria-hidden="true"></span>
            <span wire:loading.remove wire:target="login">{{ trans('labels.login') }} <i class="icon-long-arrow-right"></i></span>
        </button>

        <div class="custom-control custom-checkbox">
            <input wire:model="remember" type="checkbox" class="custom-control-input" name="remember" id="signin-remember">
            <label class="custom-control-label" for="signin-remember">{{ trans('labels.remember_me') }}</label>
        </div><!-- End .custom-checkbox -->

        <a href="{{ route('client.auth.forgot_password') }}" class="forgot-link">{{ trans('labels.forgot_password') }}?</a>
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
