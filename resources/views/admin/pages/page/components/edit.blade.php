<div class="card">
    <div class="card-header pb-0">
        <h6>
            {{ trans('labels.edit_page') }}
        </h6>
    </div>
    <div class="card-body">
        {!! Form::model($page, [
            'url' => route('admin.page.update', $page->id),
            'method' => 'PUT',
            'class' => 'page-form',
        ]) !!}
        @include('admin.pages.page.components.form')
        <div class="text-end mt-3">
            {!! Form::submit(trans('labels.update'), ['class' => 'btn btn-primary']) !!}
        </div>
        {!! Form::close() !!}
    </div>
</div>
