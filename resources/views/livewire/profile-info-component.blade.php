<div>
    @if (Session::has('message'))
        <div class="alert alert-success" role="alert">
            {{ Session::get('message') }}
        </div>
    @endif
    {!! Form::model($user, []) !!}
    <div class="row">
        <div class="col-sm-6">
            <label>{{ trans('labels.first_name') }} *</label>
            {!! Form::text('first_name', null, ['class' => 'form-control', 'required', 'wire:model' => 'user.first_name']) !!}
            @error('first_name')
                <span class="error">{{ $message }}</span>
            @enderror
        </div><!-- End .col-sm-6 -->

        <div class="col-sm-6">
            <label>{{ trans('labels.last_name') }} *</label>
            {!! Form::text('last_name', null, ['class' => 'form-control', 'required', 'wire:model' => 'user.last_name']) !!}
        </div><!-- End .col-sm-6 -->
    </div><!-- End .row -->

    <label>{{ trans('labels.email_address') }} *</label>
    {!! Form::text('email', null, ['class' => 'form-control', 'required', 'wire:model' => 'user.email']) !!}

    <button type="submit" wire:click.prevent="update" class="btn btn-outline-primary-2">
        <span wire:loading.remove>{{ trans('labels.update') }} <i class="icon-long-arrow-right"></i></span>
        <span wire:loading>Saving..</span>
    </button>
    {!! Form::close() !!}
</div>
