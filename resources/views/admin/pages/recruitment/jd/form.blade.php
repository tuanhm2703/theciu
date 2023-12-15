<div class="card mx-3">
    <div class="card-header pb-0">
        <h6 class="text-uppercase">Thông tin chung</h6>
    </div>
    <div class="card-body pt-0">
        <div class="row">
            <div class="col-md-6">
                {!! Form::label('name', trans('labels.name') . ': ', ['class' => 'custom-control-label']) !!}
                {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Nhập vào', 'required']) !!}
            </div>
            <div class="col-md-3">
                {!! Form::label('group', trans('labels.department_group') . ': ', ['class' => 'custom-control-label']) !!}
                {!! Form::select('group', $groups, isset($jd) ? [$jd->group] : null, ['class' => 'form-control']) !!}
            </div>
            <div class="col-md-3">
                {!! Form::label('job_type', trans('labels.job_type') . ': ', ['class' => 'custom-control-label']) !!}
                {!! Form::select('job_type', $job_types, isset($jd) ? [$jd->job_type] : null, ['class' => 'form-control']) !!}
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-6">
                {!! Form::label('from_date', trans('labels.from_date') . ': ', ['class' => 'custom-control-label']) !!}
                <div class="input-group">
                    <span class="input-group-text" id="basic-addon2"><i class="ni ni-calendar-grid-58"></i></span>
                    {!! Form::text('from_date', null, [
                        'class' => 'form-control datetimepicker',
                        'placeholder' => 'Nhập vào',
                        'required',
                    ]) !!}
                </div>
            </div>
            <div class="col-md-6">
                {!! Form::label('to_date', trans('labels.to_date') . ': ', ['class' => 'custom-control-label']) !!}
                <div class="input-group">
                    <span class="input-group-text" id="basic-addon2"><i class="ni ni-calendar-grid-58"></i></span>
                    {!! Form::text('to_date', null, [
                        'class' => 'form-control datetimepicker',
                        'placeholder' => 'Nhập vào',
                        'required',
                    ]) !!}
                </div>
            </div>
        </div>
         <div class="row mt-3">
            <div class="col-md-12">
                {!! Form::label('short_description', trans('labels.short_description') . ': ', ['class' => 'custom-control-label']) !!}
                {!! Form::textarea('short_description', null, [
                    'class' => 'form-control summernote',
                    'placeholder' => 'Nhập vào',
                    'required',
                    'rows' => '5',
                ]) !!}
            </div>
        </div>
    </div>
</div>
<div class="card mx-3 mt-3">
    <div class="card-header pb-0">
        <h6 class="text-uppercase">Thông tin chi tiết</h6>
    </div>
    <div class="card-body pt-0">
        <div class="row mt-3">
            <div class="col-md-12">
                {!! Form::label('description', trans('labels.description') . ': ', ['class' => 'custom-control-label']) !!}
                {!! Form::textarea('description', null, [
                    'class' => 'form-control summernote',
                    'placeholder' => 'Nhập vào',
                    'required',
                    'rows' => '5',
                ]) !!}
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-12">
                {!! Form::label('requirement', trans('labels.job_requirement') . ': ', ['class' => 'custom-control-label']) !!}
                {!! Form::textarea('requirement summernote', null, [
                    'class' => 'form-control',
                    'placeholder' => 'Nhập vào',
                    'required',
                    'rows' => '5',
                ]) !!}
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-12">
                {!! Form::label('benefit', trans('labels.benefit') . ': ', ['class' => 'custom-control-label']) !!}
                {!! Form::textarea('benefit', null, [
                    'class' => 'form-control summernote',
                    'placeholder' => 'Nhập vào',
                    'required',
                    'rows' => '5',
                ]) !!}
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-12">
                {!! Form::label('featured', trans('labels.hot_job') . ': ', ['class' => 'custom-control-label']) !!}
                <div class="form-check form-switch">
                    {!! Form::checkbox('featured', null, null, ['class' => 'form-check-input']) !!}
                </div>
            </div>
        </div>
    </div>
</div>
@push('js')
<script>
    $(document).ready(function () {
            $('select[name=group]').select2({
            tags: true
        })
        $('select[name=job_type]').select2({
            tags: true
        })
        })
    </script>
@endpush
