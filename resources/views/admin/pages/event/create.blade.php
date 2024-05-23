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
                {!! Form::open([
                    'url' => route('admin.event.store'),
                    'method' => 'POST',
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
    (() => {
        const tempIdList = [];
        $('.product-table').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                url: "{{ route('admin.ajax.product.paginate') }}",
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
    })()
</script>

@endpush

