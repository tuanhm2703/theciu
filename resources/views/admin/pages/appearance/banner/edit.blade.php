<div class="card">
    <div class="card-header">
        <h6>{{ trans('labels.create_banner') }}</h6>
    </div>
    <div class="card-body pt-0">
        {!! Form::model($banner, [
            'url' => route('admin.appearance.banner.update', $banner->id),
            'method' => 'PUT',
            'class' => 'banner-form',
        ]) !!}
        @include('admin.pages.appearance.banner.form.form')
        <div class="text-end">
            <button class="btn btn-primary submit-btn">{{ trans('labels.update') }}</button>
        </div>
        {!! Form::close() !!}
    </div>
</div>
