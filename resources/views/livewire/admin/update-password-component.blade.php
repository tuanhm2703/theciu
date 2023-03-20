<div>
    @if (Session::has('success'))
        <div class="text-success">
            {{ Session::get('success') }}
        </div>
    @endif
    <form autocomplete="false">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    {!! Form::label('old_password', trans('labels.old_password'), ['class' => 'form-control-label']) !!}
                    {!! Form::password('old_password', ['class' => 'form-control', 'wire:model' => 'old_password']) !!}
                </div>
            </div>
            @error('old_password')
            <div class="error">{{ $message }}</div>
            @enderror
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::label('new_password', trans('labels.new_password'), ['class' => 'form-control-label']) !!}
                    {!! Form::password('new_password', ['class' => 'form-control', 'wire:model' => 'new_password']) !!}
                </div>
                @error('new_password')
                <div class="error">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::label('new_password_confirmation', trans('labels.password_confirmation'), [
                        'class' => 'form-control-label',
                    ]) !!}
                    {!! Form::password('new_password_confirmation', [
                        'class' => 'form-control',
                        'wire:model' => 'new_password_confirmation',
                    ]) !!}
                </div>
                @error('new_password_confirmation')
                <div class="error">{{ $message }}</div>@enderror
            </div>
        </div>
        <div class="text-end">
            <button wire:click="updatePassword" class="btn btn-primary">{{ trans('labels.update') }}</button>
        </div>
    </form>
</div>
