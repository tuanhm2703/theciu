<div class="card">
    <div class="card-header pb-0">
        <h6>
            {{ trans('labels.create_page') }}
        </h6>
    </div>
    <div class="card-body">
        {!! Form::open([
            'url' => route('admin.page.store'),
            'method' => 'POST',
            'class' => 'page-form',
        ]) !!}
        @include('admin.pages.page.components.form')
        <div class="text-end mt-3">
            {!! Form::submit(trans('labels.create'), ['class' => 'btn btn-primary']) !!}
        </div>
        {!! Form::close() !!}
    </div>
</div>
