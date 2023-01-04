<div class="card m-3">
    <div class="card-header">
        <h6 class="text-center text-uppercase">{{ trans('labels.create_blog') }}</h6>
    </div>
</div>
{!! Form::open([
    'url' => route('admin.appearance.blog.store'),
    'method' => 'POST',
    'class' => 'blog-form',
]) !!}
@include('admin.pages.appearance.blog.form.form')
<div class="text-end m-3">
    <button class="btn btn-primary submit-btn">{{ trans('labels.create') }}</button>
</div>
{!! Form::close() !!}
<script>
</script>
