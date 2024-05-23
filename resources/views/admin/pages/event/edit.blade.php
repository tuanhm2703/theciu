@extends('admin.layouts.app', ['class' => 'g-sidenav-show', 'headTitle' => trans('labels.create_event')])
@push('style')
    <style>
        .footer-widgets.footer.footer-2 * {
            max-width: 100%;
        }
    </style>
    <style>
        .product-table {
            font-size: 13px !important;
        }
    </style>
@endpush
@section('content')
    @include('admin.layouts.navbars.auth.topnav', ['title' => trans('labels.create_event')])
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h5 class="text-start text-uppercase">{{ trans('labels.create_event') }}</h5>
            </div>
            <div class="card-body pt-0">
                {!! Form::model($event, [
                    'url' => route('admin.event.update', $event->id),
                    'method' => 'PUT',
                    'class' => 'event-form',
                ]) !!}
                @include('admin.pages.event.form')
                {!! Form::close() !!}
            </div>
        </div>
        @include('admin.layouts.footers.auth.footer')
    </div>
@endsection
@push('js')
    <script>
        let tempIdList = @json($event->products()->pluck('id')->toArray());
        (() => {
            $('.product-table').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": {
                    url: "{{ route('admin.event.product.paginate') }}",
                    type: "GET",
                    data: (d) => {
                        d.selectedIds = tempIdList
                    }
                },
                "columns": [{
                        data: "id",
                        render: function(data, type, row) {
                            if (type === 'display') {
                                return `<div class="form-check text-center form-check-info">
                                        <input type="checkbox" data-product-id="${data}" ${tempIdList.indexOf(data) >= 0 ? 'checked' : ''} class="editor-active form-check-input child-checkbox">
                                    </div>`
                            }
                            return data;
                        },
                        className: "dt-body-center",
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: "name"
                    },
                    {
                        data: "price_info"
                    },
                    {
                        data: "quantity_info"
                    },
                ],
            });
            $('.product-table').on('change', '.child-checkbox', function() {
                const productId = parseInt($(this).attr('data-product-id'))
                if ($(this).is(':checked')) {
                    tempIdList.push(productId)
                } else {
                    tempIdList.splice(tempIdList.indexOf(productId), 1)
                }
            })
            const file = FilePond.create(document.querySelector('input[name=image]'), {
                imagePreviewHeight: 170,
                storeAsFile: true,
                files: '{{ $event->image?->path_with_domain }}',
                labelIdle: 'Kéo thả file hoặc <span class="filepond--label-action"> Chọn </span>'
            })
            $('form').ajaxForm({
                beforeSend: () => {
                    $('.submit-btn').loading()
                },
                data: {
                    product_ids: tempIdList,
                    image: file.getFile(1),
                },
                dataType: 'json',
                error: (err) => {
                    $('.submit-btn').loading(false)
                },
                success: (res) => {
                    toast.success(`{{ trans('toast.action_successful') }}`, res.data.message)
                    setTimeout(() => {
                        window.location.href = res.data.url
                    }, 1000);
                }
            })
        })()
    </script>
@endpush
