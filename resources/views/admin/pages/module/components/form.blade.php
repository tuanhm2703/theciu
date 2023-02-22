<div class="row">
    <div class="col-12">
        <div class="form-group">
            {!! Form::label('name', trans('labels.name'), ['class' => 'custom-label-control m-0']) !!}
            {!! Form::text('name', null, ['placeholder' => 'Nhập tên', 'class' => 'form-control']) !!}
        </div>
    </div>
    <div class="col-12">
        <div class="form-group">
            {!! Form::label('name', trans('labels.permission'), ['class' => 'custom-label-control m-0']) !!}
            <br>
            {!! Form::select('permission_ids[]', $permissions->pluck('name', 'id')->toArray(), isset($role) ? $role->permission_ids : [], ['class' => 'select2 form-control', 'multiple']) !!}
        </div>
    </div>
</div>
