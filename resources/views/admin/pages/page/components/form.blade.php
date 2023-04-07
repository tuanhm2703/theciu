<div>
    {!! Form::label('title', trans('labels.title'), []) !!}
    {!! Form::text('title', null, ['class' => 'form-control', 'required']) !!}
</div>
<div>
    {!! Form::label('order', trans('labels.position'), []) !!}
    {!! Form::number('order', 0, ['class' => 'form-control', 'required']) !!}
</div>
<div class="mt-3">
    {!! Form::label('content', trans('labels.content'), []) !!}
    {!! Form::textarea('content', null, ['class' => 'summernote', 'required']) !!}
</div>
