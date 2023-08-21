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
<div class="mt-3">
    {!! Form::label('type', trans('labels.type') . ':', ['class' => 'custom-label-control m-0']) !!}
    {!! Form::select('type', App\Enums\BannerType::getOptions(), isset($banner) ? $banner->type : null, [
        'class' => 'form-control',
    ]) !!}
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
<div class="row mt-3" id="banner-img">
    <div class="col-md-6">
        {!! Form::label('image', trans('labels.image') . ' (Desktop screen): ', ['class' => 'custom-label-control']) !!}
        {!! Form::file('image', ['class' => 'form-control']) !!}
    </div>
    <div class="col-md-6">
        {!! Form::label('phoneImage', trans('labels.image') . ' (Phone screen): ', ['class' => 'custom-label-control']) !!}
        {!! Form::file('phoneImage', ['class' => 'form-control']) !!}
    </div>
</div>
<div class="col-12" id="popup-img">
    {!! Form::label('image-popup', trans('labels.image'), ['class' => 'custom-label-control']) !!}
    {!! Form::file('image-popup', ['class' => 'form-control']) !!}
</div>
<script>
    $(document).ready(function() {
        if ($('select[name=type]').val() == @json(App\Enums\BannerType::BANNER)) {
            $('#banner-img').show()
            $('#popup-img').hide()
        } else {
            $('#banner-img').hide()
            $('#popup-img').show()
        }
        $('select[name=type]').on('change', function() {
            if ($('select[name=type]').val() == @json(App\Enums\BannerType::BANNER)) {
                $('#banner-img').show()
                $('#popup-img').hide()
            } else {
                $('#banner-img').hide()
                $('#popup-img').show()
            }
        })
    })
</script>
