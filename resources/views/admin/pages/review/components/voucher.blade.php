<div class="card">
    <div class="card-header">
        <h6>Danh sách voucher</h6>
    </div>
    <div class="card-body pt-0">
        <div class="table-responsive">
            <table class="voucher-table">
                <thead>
                    <tr>
                        <th class="text-uppercase text-secondary text-xs font-weight-bolder">No.</th>
                        <th class="w-10 text-uppercase text-secondary text-xs font-weight-bolder">
                            {{ trans('labels.voucher_name') }}</th>
                        <th class="w-10 text-uppercase text-secondary text-xs font-weight-bolder">
                            {{ trans('labels.voucher_code') }}</th>
                        <th class="w-10 text-uppercase text-secondary text-xs font-weight-bolder">
                            {{ trans('labels.voucher_type') }}</th>
                        <th class="text-uppercase text-secondary text-xs font-weight-bolder">
                            {{ trans('labels.display') }}</th>
                        <th class="text-uppercase text-secondary text-xs font-weight-bolder">
                            {{ trans('labels.from_date') }}</th>
                        <th class="text-uppercase text-secondary text-xs font-weight-bolder">
                            {{ trans('labels.to_date') }}</th>
                        <th class="text-uppercase text-secondary text-xs font-weight-bolder text-center">
                            {{ trans('labels.status') }}</th>
                        <th class="text-uppercase text-secondary text-xs font-weight-bolder text-center">
                            {{ trans('labels.action') }}</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
<script>
    (() => {
        let voucherTable = $('.voucher-table').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "{{ route('admin.review.voucher.paginate') }}",
            "columns": [{
                    data: 'name',
                    render: function(data, type, full, meta) {
                        const info = voucherTable.page.info()
                        const rowNumber = meta.row + 1;
                        return (info.page) * info.length + rowNumber

                    }
                },
                {
                    data: "name"
                },
                {
                    data: "code"
                },
                {
                    data: "voucher_type.name"
                },
                {
                    data: "display"
                },
                {
                    data: "begin",
                },
                {
                    data: "end",
                },
                {
                    data: 'status',
                },
                {
                    data: 'action',
                    sortable: false,
                    searchable: false
                }
            ],
            initComplete: function(settings, json) {
                $("[data-bs-toggle=tooltip]").tooltip({
                    html: true
                });
            }
        });
    })()
</script>
