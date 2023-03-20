<div class="card card-plain">
    <div class="card-header pb-0 text-left">
        <h4 class="font-weight-bolder text-primary text-gradient">Thêm danh mục</h4>
    </div>
    <div class="card-body pb-3">

        {!! Form::model($category, [
            'route' => ['admin.category.update', $category->id],
            'method' => 'PUT',
            'class' => 'category-form',
        ]) !!}
        @include('admin.pages.category.form.form')
        <div class="text-end">
            <button class="btn btn-primary mt-3 submit-btn" type="submit"
                style="z-index: 1">{{ trans('labels.update') }}</button>
        </div>
        {!! Form::close() !!}
    </div>
</div>

<script>
    (() => {
        const imgSource = `{{ optional($category->image)->path_with_original_size }}`
        const file = FilePond.create(document.querySelector('input[name=image]'), {
            imagePreviewHeight: 170,
            storeAsFile: true,
            files: [imgSource],
            labelIdle: 'Kéo thả file hoặc <span class="filepond--label-action"> Chọn </span>'
        })
    })()
</script>
