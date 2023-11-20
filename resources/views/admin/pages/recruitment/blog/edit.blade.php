<div class="card m-3">
    <div class="card-header">
        <h6 class="text-center text-uppercase">{{ trans('labels.update_blog') }}</h6>
    </div>
</div>
{!! Form::model($blog, [
    'url' => route('admin.appearance.blog.update', $blog->id),
    'method' => 'PUT',
    'class' => 'blog-form',
]) !!}
@include('admin.pages.recruitment.blog.form.form')
<div class="text-end m-3">
    <button class="btn btn-primary submit-btn">{{ trans('labels.update') }}</button>
</div>
{!! Form::close() !!}
<script>
</script>
