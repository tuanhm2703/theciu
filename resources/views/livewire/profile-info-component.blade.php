<div>
    <div>
        @if (Session::has('message'))
            <div class="alert alert-success mb-3" role="alert">
                {{ Session::get('message') }}
            </div>
        @endif
        {!! Form::model($user, []) !!}
        <div class="row">
            <div class="col-sm-6">
                <label>{{ trans('labels.first_name') }} *</label>
                {!! Form::text('first_name', null, ['class' => 'form-control', 'required', 'wire:model' => 'user.first_name']) !!}
                @error('user.first_name')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div><!-- End .col-sm-6 -->

            <div class="col-sm-6">
                <label>{{ trans('labels.last_name') }} *</label>
                {!! Form::text('last_name', null, ['class' => 'form-control', 'required', 'wire:model' => 'user.last_name']) !!}
            </div><!-- End .col-sm-6 -->
        </div><!-- End .row -->

        <div class="row">
            <div class="col-12 col-lg-6">
                <label>{{ trans('labels.email_address') }} *</label>
                {!! Form::text('email', null, ['class' => 'form-control', 'required', 'wire:model' => 'user.email']) !!}
                @error('user.email')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-12 col-lg-6">
                <label>{{ trans('labels.phone') }} *</label>
                <div class="position-relative">
                    <span>{{ $user->phone }}</span>
                    <a class="d-flex align-items-center" href="{{ route('client.auth.profile.phone') }}"
                        style="position: absolute;
                               top: 50%;
                               right: 0;
                               transform: translate(-10%, -50%);}">
                        {{ trans('labels.change_phone') }}
                    </a>
                </div>
                @error('user.phone')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>
        </div>
        @if (empty(customer()->provider))
            <div class="row">
                <div class="col-12 col-lg-6">
                    {!! Form::label('password', trans('labels.password'), []) !!}
                    <div class="position-relative">
                        <input type="password" class="form-control" readonly name="password" disabled value="********">
                        <a class="d-flex align-items-center" href="{{ route('client.auth.profile.password') }}"
                            style="position: absolute;
                               top: 50%;
                               right: 0;
                               transform: translate(-10%, -50%);}">
                            {{ trans('labels.change_password') }}
                        </a>
                    </div>
                </div>
            </div>
        @endif
        <button type="submit" wire:click.prevent="update" class="btn btn-outline-primary-2">
            <span wire:loading.remove wire:target="update">{{ trans('labels.update') }} <i
                    class="icon-long-arrow-right"></i></span>
            <span wire:loading wire:target="update">Saving..</span>
        </button>
        {!! Form::close() !!}
    </div>
</div>
