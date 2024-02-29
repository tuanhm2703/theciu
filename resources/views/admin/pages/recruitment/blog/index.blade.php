@extends('admin.layouts.app')
@push('style')
    <style>
        .select2-container {
            width: 100% !important;
        }
    </style>
@endpush
@section('content')
    @include('admin.layouts.navbars.auth.topnav', ['title' => trans('labels.blog')])
    <div class="container-fluid">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h6>{{ trans('labels.blog_list') }}</h6>
                <a class="btn btn-primary ajax-modal-btn" href="javascript:void(0)" data-modal-size="modal-lg"
                    data-callback="initCreateForm()" data-link="{{ route('admin.recruitment.blog.create') }}">
                    {{ trans('labels.create_blog') }}</a>
            </div>
            <div class="card-body">
                <table class="table blog-table align-items-center">
                    <thead>
                        <tr>
                            <th class="text-uppercase text-secondary text-xs font-weight-bolder">
                                {{ trans('labels.title') }}</th>
                            <th class="text-uppercase text-secondary text-xs font-weight-bolder text-center">
                                {{ trans('labels.image') }}</th>
                            <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder">
                                {{ trans('labels.status') }}</th>
                            <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder">
                                {{ trans('labels.action') }}</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
        @include('admin.layouts.footers.auth.footer')
    </div>
@endsection
@push('js')
    <script>
        const blogTable = $('.blog-table').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "{{ route('admin.ajax.appearance.blog.paginate') }}?type={{ App\Enums\BlogType::CAREER }}",
            "columns": [{
                    data: "title"
                },
                {
                    data: "image",
                    className: 'text-center'
                },
                {
                    data: 'status',
                    className: 'text-center'
                },
                {
                    data: 'action',
                    orderable: false,
                    searchable: false
                }
            ],
            "initComplete": function(settings, json) {
                // showConfirm(content = 'Demo')
                $('.ajax-form-confirm').ajaxForm({
                    success: (res) => {
                        blogTable.ajax.reload()
                    }
                })
            }
        });
        $('.blog-table').on('change', '.blog-status', (e) => {
            const status = $(e.target).is(':checked') ? 1 : 0
            const url = $(e.target).attr('data-submit-url')
            $.ajax({
                url: url,
                type: 'PUT',
                data: {
                    status
                },
                success: (res) => {
                    toast.success(`{{ trans('toast.action_successful') }}`, res.data.message)
                }
            })
        })

        const initEditForm = (blog) => {
            const imgSource = blog.image ? [blog.image.path_with_original_size] : []
            const file = FilePond.create(document.querySelector('input[name=image]'), {
                imagePreviewHeight: 170,
                storeAsFile: true,
                labelIdle: 'Kéo thả file hoặc <span class="filepond--label-action"> Chọn </span>',
                files: imgSource
            })
            $('.blog-form').ajaxForm({
                beforeSend: () => {
                    $('.submit-btn').loading()
                },
                data: {
                    image: file.getFile(1)
                },
                dataType: 'json',
                success: (res) => {
                    toast.success(`{{ trans('toast.action_successful') }}`, res.data.message)
                    $('.submit-btn').loading(false)
                    blogTable.ajax.reload()
                    $('.modal').modal('hide')
                }
            })
        }

        const initCreateForm = () => {
            const file = FilePond.create(document.querySelector('input[name=image]'), {
                imagePreviewHeight: 170,
                storeAsFile: true,
                labelIdle: 'Kéo thả file hoặc <span class="filepond--label-action"> Chọn </span>'
            })
            $('.blog-form').ajaxForm({
                beforeSend: () => {
                    $('.submit-btn').loading()
                },
                data: {
                    image: file.getFile(1)
                },
                dataType: 'json',
                success: (res) => {
                    toast.success(`{{ trans('toast.action_successful') }}`, res.data.message)
                    $('.submit-btn').loading(false)
                    $('.modal').modal('hide')
                }
            })
        }
    </script>
@endpush
