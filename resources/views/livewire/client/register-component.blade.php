<div>
    {!! Form::open([
        'url' => route('client.auth.register'),
        'method' => 'POST',
        'id' => 'register-form',
    ]) !!}
    <div class="form-group">
        {!! Form::label('username', trans('labels.phone_or_email') . '*', []) !!}
        {!! Form::text('username', null, ['class' => 'form-control', 'required', 'wire:model' => 'username']) !!}
        @error('username')
            <div class="mt-1">
                <span class="text-danger">{{ $message }}</span>
            </div>
        @enderror
    </div><!-- End .form-group -->
    <div class="row">
        <div class="form-group col-12 col-md-6">
            {!! Form::label('first_name', trans('labels.first_name') . '*', []) !!}
            {!! Form::text('first_name', null, ['class' => 'form-control', 'required', 'wire:model' => 'first_name']) !!}
            @error('first_name')
                <div class="mt-1">
                    <span class="text-danger">{{ $message }}</span>
                </div>
            @enderror
        </div><!-- End .form-group -->
        <div class="form-group col-12 col-md-6">
            {!! Form::label('last_name', trans('labels.last_name') . '*', []) !!}
            {!! Form::text('last_name', null, ['class' => 'form-control', 'required', 'wire:model' => 'last_name']) !!}
            @error('last_name')
                <div class="mt-1">
                    <span class="text-danger">{{ $message }}</span>
                </div>
            @enderror
        </div><!-- End .form-group -->
    </div>
    <div class="form-group">
        {!! Form::label('password', trans('labels.password') . '*', []) !!}
        {!! Form::password('password', ['class' => 'form-control', 'required', 'wire:model' => 'password']) !!}
        @error('password')
            <div class="mt-1">
                <span class="text-danger">{{ $message }}</span>
            </div>
        @enderror
    </div><!-- End .form-group -->
    <div class="form-group">
        {!! Form::label('password_confirmation', trans('labels.password_confirmation') . '*', []) !!}
        {!! Form::password('password_confirmation', [
            'class' => 'form-control',
            'required',
            'wire:model' => 'password_confirmation',
        ]) !!}
    </div><!-- End .form-group -->
    <div class="form-footer">
        <button type="button" wire:click.prevent="register" class="btn btn-outline-primary-2">
            <span wire:loading wire:target="register" class="spinner-border spinner-border-sm mr-3" role="status" aria-hidden="true"></span>
            <span wire:loading.remove wire:target="register">{{ trans('labels.signin') }}<i class="icon-long-arrow-right"></i></span>
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
