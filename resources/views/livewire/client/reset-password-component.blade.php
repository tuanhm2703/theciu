<div class="w-100">
    {!! Form::open([
        'method' => 'POST',
        'id' => 'reset-password-form',
        'class' => 'p-5',
    ]) !!}
    <div class="form-group">
        {!! Form::label('new_password', trans('labels.new_password') . '*', []) !!}
        {!! Form::password('new_password', ['class' => 'form-control', 'required', 'wire:model.lazy' => 'new_password']) !!}
    </div><!-- End .form-group -->
    <div class="form-group">
        {!! Form::label('new_password_confirmation', trans('labels.new_password_confirmation') . '*', []) !!}
        {!! Form::password('new_password_confirmation', ['class' => 'form-control', 'required', 'wire:model.lazy' => 'new_password_confirmation']) !!}
    </div><!-- End .form-group -->
    <input type="hidden" wire:model="token">
    <input type="hidden" wire:model="username">
    <div class="form-footer text-right">
        <button type="submit" id="submitBtn" class="btn btn-outline-primary-2" wire:click.prevent="updatePassword">
            <span class="spinner-border spinner-border-sm pr-3" role="status" aria-hidden="true" wire:loading wire:target="updatePassword"></span>
            <span>{{ trans('labels.update') }}</span>
            <i class="icon-long-arrow-right"></i>
        </button>
    </div><!-- End .form-footer -->
    {!! Form::close() !!}
</div>
