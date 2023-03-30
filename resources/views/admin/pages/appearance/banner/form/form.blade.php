@php
    $arr = [];
    $arr['-1'] = 'Random';
    $maxOrder = App\Models\Banner::active()->max('order');
    $maxOrder = $maxOrder == -1 ? $maxOrder + 2 : $maxOrder + 1;
    for ($i = 1; $i <= $maxOrder; $i++) {
        $arr["$i"] = "$i";
    }
@endphp
<div class="row">
    <div class="col-md-6">
        {!! Form::label('title', trans('labels.title') . ': ', ['class' => 'custom-label-control m-0']) !!}
        {!! Form::text('title', null, ['class' => 'form-control', 'placeholder' => 'Nhập vào', 'required']) !!}
    </div>
    <div class="col-md-6">
        {!! Form::label('order', trans('labels.position') . ': ', ['class' => 'custom-label-control m-0']) !!}
        {!! Form::select(
            'order',
            $arr,
            [isset($banner) ? $banner->order : null],
            ['class' => 'form-control', 'required'],
        ) !!}
    </div>
</div>
<div class="row mt-3">
    <div class="col-md-12">
        {!! Form::label('url', trans('labels.url') . ':', ['class' => 'custom-label-control m-0']) !!}
        {!! Form::text('url', null, ['class' => 'form-control', 'placeholder' => 'Nhập vào', 'required']) !!}
    </div>
</div>
<div class="row mt-3">
    <div class="col-md-12">
        {!! Form::label('description', trans('labels.description') . ': ', ['class' => 'custom-label-control m-0']) !!}
        {!! Form::textarea('description', null, [
            'class' => 'form-control',
            'placeholder' => 'Nhập vào',
            'required',
            'rows' => 5,
        ]) !!}
    </div>
</div>
<div class="row mt-3">
    <div class="col-md-6">
        {!! Form::label('image', trans('labels.image') . ' (Desktop screen): ', ['class' => 'custom-label-control']) !!}
        {!! Form::file('image', ['class' => 'form-control', 'required']) !!}
    </div>
    <div class="col-md-6">
        {!! Form::label('phoneImage', trans('labels.image') . ' (Phone screen): ', ['class' => 'custom-label-control']) !!}
        {!! Form::file('phoneImage', ['class' => 'form-control', 'required']) !!}
    </div>
</div>
