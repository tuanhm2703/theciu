<div class="card">
    <div class="card-header">
        <h6>{{ trans('labels.create') }}</h6>
    </div>
    <div class="card-body pt-0">
        {!! Form::open([
            'url' => route('admin.setting.address.store'),
            'method' => 'POST',
            'class' => 'address-form',
        ]) !!}
        @include('admin.pages.setting.address.components.form')
        <div class="text-end">
            <button class="btn btn-primary address-submit-btn">{{ trans('labels.update') }}</button>
        </div>
        {!! Form::close() !!}
    </div>
</div>
