@extends('admin.layouts.app', ['class' => 'g-sidenav-show', 'headTitle' => trans('labels.product_list')])
@push('style')
@endpush
@section('content')
    @include('admin.layouts.navbars.auth.topnav', ['title' => trans('labels.banner')])
    <div class="container-fluid">
        <div class="card mb-4">
            <div class="card-header pb-0">
                <div class="d-flex justify-content-between">
                    <h6>{{ trans('labels.banner_list') }}</h6>
                    <a class="btn btn-primary ajax-modal-btn" href="javascript:void(0)" data-init-app="false"
                        data-link="{{ route('admin.appearance.banner.create') }}" data-callback='initCreateFormFunc()'>
                        {{ trans('labels.create_banner') }}</a>
                </div>
            </div>
            <div class="card-body px-0 pt-0 pb-2">

                <div class="table-responsive p-3">
                    <table class="banner-table table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xs font-weight-bolder">
                                    {{ trans('labels.title') }}</th>
                                    <th class="text-uppercase text-secondary text-xs font-weight-bolder">
                                        {{ trans('labels.type') }}</th>
                                <th class="text-uppercase text-secondary text-xs font-weight-bolder">
                                    {{ trans('labels.url') }}</th>
                                <th class="text-uppercase text-secondary text-xs font-weight-bolder text-center">
                                    {{ trans('labels.image') }}</th>
                                <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder">
                                    {{ trans('labels.position') }}</th>
                                <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder">
                                    {{ trans('labels.status') }}</th>
                                <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder">
                                    {{ trans('labels.action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @include('admin.layouts.footers.auth.footer')
    </div>
@endsection
@push('js')
    <script>
        const bannerTable = $('.banner-table').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "{{ route('admin.ajax.appearance.banner.paginate') }}",
            "columns": [{
                    data: "title"
                },
                {
                    data: 'type',
                },
                {
                    data: "url",
                },
                {
                    data: "image",
                    className: 'text-center'
                },
                {
                    data: 'order',
                    className: 'text-center'
                },
                {
                    data: 'status',
                    className: 'text-center'
                },
                {
                    data: 'action'
                }
            ],
            "initComplete": function(settings, json) {
                // showConfirm(content = 'Demo')
                $('.ajax-form-confirm').ajaxForm({
                    success: (res) => {
                        bannerTable.ajax.reload()
                    }
                })
            }
        });
        $('.banner-table').on('change', '.banner-status', (e) => {
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

        const initEditFormFunc = (banner) => {
            $('.datetimepicker').flatpickr({
                enableTime: true,
                time_24hr: true,
                minDate: `{{ now()->format('Y-m-d') }}`,
            })
            const imgSource = banner.desktop_image?.path_with_original_size
            const imgPhoneSource = banner.phone_image?.path_with_original_size
            const file = FilePond.create(document.querySelector('input[name=image]'), {
                imagePreviewHeight: 170,
                storeAsFile: true,
                files: imgSource ? [imgSource] : [],
                labelIdle: 'Kéo thả file hoặc <span class="filepond--label-action"> Chọn </span>'
            })
            const filePhone = FilePond.create(document.querySelector('input[name=phoneImage]'), {
                imagePreviewHeight: 170,
                storeAsFile: true,
                files: imgPhoneSource ? [imgPhoneSource] : [],
                labelIdle: 'Kéo thả file hoặc <span class="filepond--label-action"> Chọn </span>'
            })
            $('form').ajaxForm({
                beforeSend: () => {
                    $('.submit-btn').loading()
                },
                data: {
                    image: file.getFile(1),
                    phoneImage: filePhone.getFile(1),
                },
                dataType: 'json',
                success: (res) => {
                    $('.submit-btn').loading(false)
                    bannerTable.ajax.reload()
                    $('.modal').modal('hide')
                }
            })
        }
        const initCreateFormFunc = () => {
            $('.datetimepicker').flatpickr({
                enableTime: true,
                time_24hr: true,
                minDate: `{{ now()->format('Y-m-d') }}`,
            })
            const file = FilePond.create(document.querySelector('input[name=image]'), {
                imagePreviewHeight: 170,
                storeAsFile: true,
                labelIdle: 'Kéo thả file hoặc <span class="filepond--label-action"> Chọn </span>'
            })

            const filePhone = FilePond.create(document.querySelector('input[name=phoneImage]'), {
                imagePreviewHeight: 170,
                storeAsFile: true,
                labelIdle: 'Kéo thả file hoặc <span class="filepond--label-action"> Chọn </span>'
            })
            $('form').ajaxForm({
                beforeSend: () => {
                    $('.submit-btn').loading()
                },
                data: {
                    image: file.getFile(1),
                    phoneImage: filePhone.getFile(1),
                },
                dataType: 'json',
                success: (res) => {
                    $('.submit-btn').loading(false)
                    bannerTable.ajax.reload()
                    $('.modal').modal('hide')
                }
            })
        }
    </script>
@endpush
