@extends('admin.layouts.app')
@push('style')
    <style>
        .video-js {
            width: 100% !important;
        }

        .review-products h6 {
            text-overflow: ellipsis !important;
            overflow: hidden !important;
            width: 200px !important;
            white-space: nowrap !important;
        }
    </style>
@endpush
@section('content')
    @include('admin.layouts.navbars.auth.topnav', ['title' => trans('labels.rank')])
    <div class="container-fluid">
        <div class="card">
            <h6 class="card-header d-flex justify-content-between">
                {{ trans('labels.rank_list') }}
                <a class="btn btn-primary ajax-modal-btn" href="javascript:void(0)" data-init-app="false"
                    data-modal-size="modal-xl" data-link="{{ route('admin.review.setting.voucher') }}">
                    <i class="far fas fa-cog me-1"></i>Cài đặt review</a>
            </h6>
            <ul class="nav nav-tabs" id="review-star-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="javascript::void()" role="tab"
                        data-review-star="0" aria-controls="order-list" aria-selected="true">Tất cả <span
                            class="review-count"></span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="javascript::void()" role="tab" data-review-star="1"
                        aria-controls="order-list" aria-selected="true">1 Sao <span class="review-count"></span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="javascript::void()" role="tab" data-review-star="2"
                        aria-controls="order-list" aria-selected="true">2 Sao <span class="review-count"></span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="javascript::void()" role="tab" data-review-star="3"
                        aria-controls="order-list" aria-selected="true">3 Sao <span class="review-count"></span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="javascript::void()" role="tab" data-review-star="4"
                        aria-controls="order-list" aria-selected="true">4 Sao <span class="review-count"></span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="javascript::void()" role="tab" data-review-star="5"
                        aria-controls="order-list" aria-selected="true">5 Sao <span class="review-count"></span></a>
                </li>
            </ul>
            <div class="card-body table-responsive">
                <table class="review-table table">
                    <thead>
                        <th>No.</th>
                        <th></th>
                        <th>Sản phẩm</th>
                        <th>{{ __('labels.status') }}</th>
                        <th>{{ __('labels.details') }}</th>
                        <th>{{ __('labels.reply') }}</th>
                        <th>{{ __('labels.action') }}</th>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
        @include('admin.layouts.footers.auth.footer')
    </div>
@endsection
@push('js')
    <script>
        let table;
        const initTable = (star = 0, replied = 'all') => {
            table = $('.review-table').DataTable({
                "processing": true,
                "serverSide": true,
                "destroy": true,
                "ajax": `{{ route('admin.review.paginate') }}?star=${star}`,
                "columns": [{
                        data: 'id',
                        render: function(data, type, full, meta) {
                            const info = table.page.info()
                            const rowNumber = meta.row + 1;
                            return (info.page) * info.length + rowNumber
                        },
                        width: '5%'
                    },
                    {
                        data: 'created_at',
                        visible: false
                    },
                    {
                        data: 'products',
                        width: '10%'
                    },
                    {
                        data: 'status',
                        width: '7%'
                    },
                    {
                        data: "details",
                        width: "30%"
                    },
                    {
                        data: "reply",
                        searchable: false,
                        sortable: false
                    },
                    {
                        data: 'action',
                        sortable: false,
                        searchable: false,
                        width: '5%'
                    },
                ],
                order: [
                    [1, 'desc']
                ],
                initComplete: function(settings, json) {
                    $("[data-bs-toggle=tooltip]").tooltip({
                        html: true
                    });
                    json.review_counts.forEach(data => {
                        $(`[data-review-star=${data.product_score}] .review-count`).text(
                            `(${data.review_count})`)
                    })
                    this.api()
                        .columns()
                        .every(function(e) {
                            if (e === 5) {
                                let column = this;

                                // Create select element
                                let select = document.createElement('select');
                                column.header().replaceChildren(select);

                                // Apply listener for user change in value
                                select.addEventListener('change', function() {
                                    column.search(select.value, true, false)
                                        .draw();
                                });
                                const opt1 = document.createElement("option");
                                const opt2 = document.createElement("option");
                                const opt3 = document.createElement("option");
                                opt1.value = "0";
                                opt1.text = "(Trả lời) Tất cả";
                                opt1.selected = true

                                opt2.value = "1";
                                opt2.text = "(Trả lời) Chưa trả lời";

                                opt3.value = "2";
                                opt3.text = "(Trả lời) Đã trả lời";

                                select.classList.add('form-control')

                                // Add list of options
                                select.add(opt1);
                                select.add(opt2);
                                select.add(opt3);
                            }
                        });
                }
            });
        }
        initTable()
        $('#review-star-tab a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
            initTable($(e.currentTarget).attr('data-review-star'))
        })
    </script>
@endpush
