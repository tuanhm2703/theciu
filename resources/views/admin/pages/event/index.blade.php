@extends('admin.layouts.app', ['class' => 'g-sidenav-show', 'headTitle' => trans('labels.page_list')])
@push('style')
    <style>
        .footer-widgets.footer.footer-2 * {
            max-width: 100%;
        }
    </style>
@endpush
@section('content')
    @include('admin.layouts.navbars.auth.topnav', ['title' => trans('labels.event_list')])
    <div class="container-fluid">
        <div class="card mb-4">
            <div class="card-header pb-0">
                <div class="d-flex justify-content-between">
                    <h6>{{ trans('labels.event_list') }}</h6>
                    <a class="btn btn-primary" href="{{ route('admin.event.create') }}">{{ trans('labels.create') }}</a>
                </div>
            </div>
            <div class="card-body px-0 pt-0 pb-2">

                <div class="p-3">
                    <table class="table align-items-center mb-0 event-table">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th class="">
                                    {{ trans('labels.name') }}</th>
                                    <th class="">
                                        {{ trans('labels.image') }}</th>
                                <th>{{ trans('labels.begin') }}</th>
                                <th>{{ trans('labels.end') }}</th>
                                <th>{{ trans('labels.action') }}</th>
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
        const initEventTable = () => {
            const table = $('.event-table').DataTable({
                "processing": true,
                "serverSide": true,
                "destroy": true,
                "ajax": `{{ route('admin.event.paginate') }}`,
                "columns": [
                    {
                        data: 'name',
                        render: function(data, type, full, meta) {
                            const info = eventTable.page.info()
                            const rowNumber = meta.row + 1;
                            return (info.page) * info.length + rowNumber

                        }
                    },
                    {
                        data: "name"
                    },
                    {
                        data: "image"
                    },
                    {
                        data: "from"
                    },
                    {
                        data: "to"
                    },
                    {
                        data: 'action'
                    }
                ]
            });
            return table
        }
        const eventTable = initEventTable()
    </script>
@endpush
