<div>
    <div>
        @if (Session::has('message'))
            <div class="alert alert-success mb-3" role="alert">
                {{ Session::get('message') }}
            </div>
        @endif
        @if (!$this->showPasswordForm)
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
                    {!! Form::text('phone', null, ['class' => 'form-control', 'required', 'wire:model' => 'user.email']) !!}
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
                            <input type="password" class="form-control" readonly name="password" disabled
                                value="********">
                            <a class="d-flex align-items-center" href="#" wire:click="showPasswordForm"
                                style="position: absolute;
                               top: 50%;
                               right: 0;
                               transform: translate(-10%, -50%);}">
                                <div wire:loading wire:target="showPasswordForm" class="spinner-grow"
                                    style="width: 3rem; height: 3rem;" role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>{{ trans('labels.change_password') }}
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
        @else
            <h6>{{ trans('labels.change_password') }}</h6>
            <div class="row">
                <div class="col-12 col-lg-6">
                    <label>{{ trans('labels.old_password') }} *</label>
                    {!! Form::password('old_password', ['class' => 'form-control', 'required', 'wire:model' => 'old_password']) !!}
                    @error('old_password')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div><!-- End .col-12 col-lg-6 -->
            </div><!-- End .row -->
            <div class="row">
                <div class="col-12 col-lg-6">
                    <label>{{ trans('labels.new_password') }} *</label>
                    {!! Form::password('new_password', ['class' => 'form-control', 'required', 'wire:model' => 'new_password']) !!}
                    @error('new_password')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div><!-- End .col-sm-6 -->
                <div class="col-12 col-lg-6">
                    <label>{{ trans('labels.new_password_confirmation') }} *</label>
                    {!! Form::password('new_password_confirmation', [
                        'class' => 'form-control',
                        'required',
                        'wire:model' => 'new_password_confirmation',
                    ]) !!}
                    @error('new_password_confirmation')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div><!-- End .col-sm-6 -->

            </div>
            <div class="text-right">
                <button wire:click="returnToProfile" class="btn btn-outline-primary-2 mr-3">
                    <div wire:loading wire:target="returnToProfile" class="spinner-grow"
                        style="width: 3rem; height: 3rem;" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                    <i class="fas fa-undo mr-3"></i>
                    {{ trans('labels.return') }}
                </button>
                <button wire:click="updatePassword" class="btn btn-outline-primary-2">
                    <div wire:loading wire:target="updatePassword" class="spinner-grow"
                        style="width: 3rem; height: 3rem;" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                    {{ trans('labels.update') }}
                    <i class="icon-long-arrow-right"></i>
                </button>
            </div>
        @endif
    </div>
</div>
