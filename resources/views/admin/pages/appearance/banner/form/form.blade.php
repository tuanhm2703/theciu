<div class="row">
    <div class="col-md-6">
        {!! Form::label('title', trans('labels.title') . ': ', ['class' => 'custom-label-control m-0']) !!}
        {!! Form::text('title', null, ['class' => 'form-control', 'placeholder' => 'Nhập vào', 'required']) !!}
    </div>
    <div class="col-md-6">
        {!! Form::label('order', trans('labels.position'). ": ", ['class' => 'custom-label-control m-0']) !!}
        {!! Form::select('order', [1], [], ['class' => 'form-control', 'required']) !!}
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
        {!! Form::textarea('description', null, ['class' => 'form-control', 'placeholder' => 'Nhập vào', 'required', 'rows' => 5]) !!}
    </div>
</div>
<div class="row mt-3">
    <div class="col-md-12">
        {!! Form::label('image', trans('labels.image').': ', ['class' => 'custom-label-control']) !!}
        {!! Form::file('image', ['class' => 'form-control', 'required']) !!}
    </div>
</div>
