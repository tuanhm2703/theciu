<div>
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
            <div wire:loading wire:target="returnToProfile" class="spinner-grow" style="width: 3rem; height: 3rem;"
                role="status">
                <span class="sr-only">Loading...</span>
            </div>
            <i class="fas fa-undo mr-3"></i>
            {{ trans('labels.return') }}
        </button>
        <button wire:click="updatePassword" class="btn btn-outline-primary-2">
            <div wire:loading wire:target="updatePassword" class="spinner-grow" style="width: 3rem; height: 3rem;"
                role="status">
                <span class="sr-only">Loading...</span>
            </div>
            {{ trans('labels.update') }}
            <i class="icon-long-arrow-right"></i>
        </button>
    </div>
</div>
