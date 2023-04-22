<div class="row">
    <div class="col-12">
        {!! Form::label('name', trans('labels.name'), ['class' => 'custom-label-control m-0']) !!}
        {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Nhập vào', 'required']) !!}
    </div>
    <div class="col-12">
        {!! Form::label('benefit_value', 'Benefit', ['class' => 'custom-label-control m-0']) !!}
        {!! Form::number('benefit_value', null, ['class' => 'form-control']) !!}
    </div>
</div>
<div class="row mt-3">
    <div class="col-12">
        {!! Form::label('min_value', 'Doanh thu tối thiểu', ['class' => 'custom-label-control m-0']) !!}
        {!! Form::number('min_value', null, ['class' => 'form-control']) !!}
    </div>
</div>
<div class="row mt-3">
    <div class="col-12">
        {!! Form::label('cycle', 'Hạn sử dụng (Tháng)', ['class' => 'custom-label-control m-0']) !!}
        {!! Form::number('cycle', null, ['class' => 'form-control']) !!}
    </div>
</div>
{{-- <div class="row mt-3">
    <div class="col-md-6">
        {!! Form::label('image', trans('labels.image') . ' (Desktop screen): ', ['class' => 'custom-label-control']) !!}
        {!! Form::file('image', ['class' => 'form-control', 'required']) !!}
    </div>
    <div class="col-md-6">
        {!! Form::label('phoneImage', trans('labels.image') . ' (Phone screen): ', ['class' => 'custom-label-control']) !!}
        {!! Form::file('phoneImage', ['class' => 'form-control', 'required']) !!}
    </div>
</div> --}}
