@php
    $roles = App\Models\Role::where('name', '!=', 'Super Admin')
        ->pluck('name', 'id')
        ->toArray();
@endphp
<div class="row">
    <div class="col-12 col-md-6">
        <div class="form-group">
            {!! Form::label('email', 'Email', ['class' => 'form-control-label']) !!}
            {!! Form::email('email', null, ['class' => 'form-control']) !!}
        </div>
    </div>
    <div class="col-12 col-md-6">
        <div class="form-group">
            {!! Form::label('phone', trans('labels.phone'), ['class' => 'form-control-label']) !!}
            {!! Form::text('phone', null, ['class' => 'form-control']) !!}
        </div>
    </div>
    <div class="col-12 col-md-6">
        <div class="form-group">
            {!! Form::label('name', trans('labels.fullname'), ['class' => 'form-control-label']) !!}
            {!! Form::text('name', null, ['class' => 'form-control']) !!}
        </div>
    </div>
    <div class="col-12 col-md-6">
        <div class="form-group">
            {!! Form::label('role', trans('labels.role'), ['class' => 'form-control-label']) !!}
            {!! Form::select('role_id', $roles, isset($staff) ? [optional($staff->role)->id] : null, ['class' => 'select2']) !!}
        </div>
    </div>
    @if (!isset($staff))
        <div class="col-12">
            <div class="form-group">
                {!! Form::label('password', trans('labels.password'), ['class' => 'form-control-label']) !!}
                {!! Form::password('password', ['class' => 'form-control']) !!}
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                {!! Form::label('password_confirmation', trans('labels.password_confirmation'), [
                    'class' => 'form-control-label',
                ]) !!}
                {!! Form::password('password_confirmation', ['class' => 'form-control']) !!}
            </div>
        </div>
    @endif
</div>
