<div class="card">
    <div class="card-header">
        <h5 class="text-center text-uppercase">{{ trans('labels.create_banner') }}</h5>
    </div>
    <div class="card-body pt-0">
        {!! Form::open([
            'url' => route('admin.appearance.banner.store'),
            'method' => 'POST',
            'class' => 'banner-form',
        ]) !!}
        @include('admin.pages.appearance.banner.form.form')
        <div class="text-end">
            <button class="btn btn-primary submit-btn">{{ trans('labels.create') }}</button>
        </div>
        {!! Form::close() !!}
    </div>
</div>
<script>
</script>
