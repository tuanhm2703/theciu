<div class="card">
    <h5 class="card-header">Meta Tags</h5>
    <div class="card-body">
        <div class="mb-3">
            {!! Form::label('meta[title]', 'Meta-title', []) !!}
            {!! Form::text('meta[title]', null, ['class' => 'form-control', 'required']) !!}
        </div>
        <div class="mb-3">
            {!! Form::label('meta[description]', 'Meta-description', []) !!}
            {!! Form::textarea('meta[description]', null, ['class' => 'form-control', 'max-length' => '180']) !!}
        </div>
    </div>
    <h5 class="card-header">Thông tin chung</h5>
    <div class="card-body">
        <div class="mb-3">
            <div>
                {!! Form::label('order', trans('labels.position'), []) !!}
                {!! Form::number('order', 0, ['class' => 'form-control', 'required']) !!}
            </div>
            {!! Form::label('title', trans('labels.title'), []) !!}
            {!! Form::text('title', null, ['class' => 'form-control', 'required']) !!}
        </div>
        <div class="mb-3">
            {!! Form::label('order', trans('labels.position'), []) !!}
            {!! Form::number('order', 0, ['class' => 'form-control', 'required']) !!}
        </div>
        <div>
            {!! Form::label('content', trans('labels.content'), []) !!}
            {!! Form::textarea('content', null, ['class' => 'summernote', 'required']) !!}
        </div>
    </div>
</div>
