<script>
    let voucherTable = $('.voucher-table').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": "{{ route('admin.ajax.promotion.voucher.paginate') }}",
        "columns": [{
                data: 'name',
                render: function(data, type, full, meta) {
                    const info = promotionProductTable.page.info()
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
                data: "begin",
            },
            {
                data: "end",
            },
            {
                data: 'status',
                width: '20%'
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
    const initPromotionProductTable = () => {
        return $('.promotion-table').DataTable({
            serverSide: true,
            processing: true,
            destroy: true,
            ajax: `{{ route('admin.ajax.promotion.paginate') }}`,
            columns: [{
                    data: 'name',
                    render: function(data, type, full, meta) {
                        const info = promotionProductTable.page.info()
                        const rowNumber = meta.row + 1;
                        return (info.page) * info.length + rowNumber

                    }
                },

                {
                    data: "name"
                },
                {
                    data: "product_img_list"
                },
                {
                    data: "promotiom_status_label",
                },
                {
                    data: "time",
                },
                {
                    data: 'action'
                }
            ],
            initComplete: function(settings, json) {
                $('.magnifig-img').magnificPopup({
                    type: "image",
                });
            }
        })
    }

    const initFlashSaleTable = () => {
        return $('.flash-sale-table').DataTable({
            serverSide: true,
            processing: true,
            destroy: true,
            ajax: `{{ route('admin.ajax.promotion.paginate') }}?type={{ App\Enums\PromotionType::FLASH_SALE }}`,
            columns: [{
                    data: 'name',
                    render: function(data, type, full, meta) {
                        const info = promotionProductTable.page.info()
                        const rowNumber = meta.row + 1;
                        return (info.page) * info.length + rowNumber

                    }
                },

                {
                    data: "name"
                },
                {
                    data: "product_img_list"
                },
                {
                    data: "promotiom_status_label",
                },
                {
                    data: "time",
                },
                {
                    data: 'action'
                }
            ],
            initComplete: function(settings, json) {
                $('.magnifig-img').magnificPopup({
                    type: "image",
                });
            }
        })
    }

    let promotionProductTable = initPromotionProductTable()
    let flashSaleTable = initFlashSaleTable()
    $('.voucher-table').on('change', '.voucher-status', (e) => {
        const status = $(e.target).is(':checked') ? 1 : 0
        const url = $(e.target).attr('data-submit-url')
        $.ajax({
            url: url,
            type: 'PUT',
            data: {
                status
            },
            success: (res) => {
                tata.success(`{{ trans('toast.action_successful') }}`, res.data.message)
            }
        })
    })
    $('select[name=promotion-date]').on('change', (e) => {
        promotionProductTable = initPromotionProductTable()
    })
</script>
