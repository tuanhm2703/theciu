<div class="form-group">
    <div class="form-group">
        <label for="example-text-input" class="form-control-label">{{ trans('labels.category_name') }}</label>
        <div class="input-group">
            <span class="input-group-text">
                {!! Form::select(
                    'type',
                    App\Enums\CategoryType::productCategoryTypeOptions(),
                    [isset($category) ? $category->type : null],
                    ['class' => 'form-control'],
                ) !!}
            </span>
            {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Nhập vào']) !!}
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <label for="visible" class="form-control-label">Hiển thị</label>
            <div class="form-check form-switch">
                {!! Form::checkbox('visible', null, isset($category) ? $category->visible : true, [
                    'class' => 'form-check-input',
                ]) !!}
            </div>
        </div>
        <div class="col-md-6">
            <label for="visible" class="form-control-label">Hiển thị</label>
            <div class="form-control">
                {!! Form::select(
                    'tags[]',
                    isset($category) ? $category->getTagArray() : [],
                    isset($category) ? $category->tags()->pluck('tags.id')->toArray() : [],
                    [
                        'multiple' => 'multiple',
                        'class' => 'select2-ajax',
                        'data-select2-url' => route('admin.tags.search'),
                    ],
                ) !!}
            </div>
        </div>
    </div>
    <div class="row">
        {!! Form::label('image', trans('labels.image') . ': ', ['class' => 'custom-control-label']) !!}
        {!! Form::file('image', ['form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('meta[keywords]', 'Meta-keywords', ['class' => 'form-label']) !!}
        {!! Form::text('meta[keywords]', null, ['class' => 'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('meta[description]', 'Meta-description', ['class' => 'form-label']) !!}
        {!! Form::textarea('meta[description]', null, ['class' => 'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('meta[title]', 'Meta-title', ['class' => 'form-label']) !!}
        {!! Form::text('meta[title]', null, ['class' => 'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('short_description', trans('labels.short_description'), ['class' => 'form-label']) !!}
        {!! Form::textarea('short_description', null, ['class' => 'form-control summernote']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('content', trans('labels.content'), ['class' => 'form-label']) !!}
        {!! Form::textarea('content', null, ['class' => 'form-control summernote']) !!}
    </div>
</div>
<script>
    (() => {
        $('input[name=parent_id]').val(parentId)
        $('.category-form').ajaxForm({
            beforeSend: () => {
                $('.submit-btn').loading()
            },
            success: (res) => {
                toast.success(`{{ trans('toast.action_successful') }}`, res.data.message)
                setTimeout(() => {
                    window.location.reload()
                }, 1000);
            },
            error: (err) => {
                $('.submit-btn').loading(false)
            }
        })
        const filePond = FilePond.create(document.querySelector('input[name=image]'), {
            imagePreviewHeight: 170,
            storeAsFile: true,
            labelIdle: 'Kéo thả file hoặc <span class="filepond--label-action"> Chọn </span>',
            files: @json(isset($category) && $category->image ? [$category->image->path_with_domain] : []),
            onaddfile: (error, file) => {
                let container = new DataTransfer();
                container.items.add(filePond.getFile().file);
                $('input[name=image]')[0].files = container.files
            }
        })
    })()
</script>
