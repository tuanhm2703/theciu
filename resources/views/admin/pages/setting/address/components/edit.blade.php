<div class="card">
    <div class="card-header">
        <h6>{{ trans('labels.update') }}</h6>
    </div>
    <div class="card-body pt-0">
        {!! Form::model($address, [
            'url' => route('admin.setting.address.update', $address->id),
            'method' => 'PUT',
            'class' => 'address-form',
        ]) !!}
        @include('admin.pages.setting.address.components.form')
        <div class="text-end">
            <button class="btn btn-primary submit-btn">{{ trans('labels.update') }}</button>
        </div>
        {!! Form::close() !!}
    </div>
</div>
