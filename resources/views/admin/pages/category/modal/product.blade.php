<div class="card card-plain">
    <div class="card-header pb-0 d-flex justify-content-between">
        <h5 class="font-weight-bolder text-primary text-gradient">Danh sách sản phẩm</h5>
    </div>
    <div class="card-body pb-3">
        <div class="nav-wrapper position-relative end-0">
            <input type="hidden" name="categoryId" value="{{ $category->id }}">
            <div class="nav-wrapper position-relative end-0">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#download-tutorial"
                            role="tab" aria-controls="home" aria-selected="true">Chọn</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#upload-batch" role="tab"
                            aria-controls="profile" aria-selected="false">Đăng danh sách sản phẩm</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="download-tutorial" role="tabpanel" aria-labelledby="home-tab">
                        <div class="mt-3">
                            <table class="category-product-table table w-100">
                                <thead>
                                    <th style="padding-left: 0.5rem">
                                    </th>
                                    <th>{{ trans('labels.product_name') }}</th>
                                    <th>{{ trans('labels.price') }}</th>
                                    <th>{{ trans('labels.warehouse') }}</th>
                                </thead>
                                <tbody></tbody>
                            </table>
                            <div class="text-end mt-3"><button class="btn btn-primary" id="add-product-btn">Thêm sản
                                    phẩm</button></div>
                        </div>
                    </div>
                    <div class="tab-pane" id="upload-batch" role="tabpanel" aria-labelledby="profile-tab">
                        <div class="row mt-3">
                            <div class="col-md-9">
                                <p>Đăng tải danh sách sản phẩm của bạn bằng cách sử dụng bảng Excel mẫu.</p>
                            </div>
                            <div class="col-md-3">
                                <a href="#" class="btn btn-primary">
                                    <i class="fas fa-download"></i> Tải về bản mẫu
                                </a>
                            </div>
                        </div>
                        <div>
                            <input type="file" name="product-id-list-file" class="filePond">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    (() => {
        const selectedProductIds = @json($productIds);
        $('.category-product-table').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                url: "{{ route('admin.ajax.product.paginate') }}",
                type: "GET",
                data: {
                    selected: selectedProductIds
                }
            },
            "columns": [{
                    data: "id",
                    render: function(data, type, row) {
                        if (type === 'display') {
                            return `<div class="form-check text-center form-check-info">
                                        <input type="checkbox" data-product-id="${data}" ${selectedProductIds.includes(data) ? 'checked' : ''} class="editor-active form-check-input child-checkbox">
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
                    data: "sale_price"
                },
                {
                    data: "total_stock_quantity"
                },
            ],
        });
        $('body').on('click', '.child-checkbox', (e) => {
            const productId = $(e.target).attr('data-product-id')
            if($(e.target).is(':checked')) {
                selectedProductIds.push(productId)
            } else {
                const productIdIndex = selectedProductIds.indexOf(productId)
                selectedProductIds.splice(productIdIndex, 1)
            }
        })
        const pond = FilePond.create(document.querySelector('.filePond'), {
            storeAsFile: true,
            labelIdle: 'Kéo thả file hoặc <span class="filepond--label-action"> Chọn </span>'
        });
        $('#add-product-btn').on('click', (e) => {
            e.preventDefault()
            // let productIds = []
            // const checkboxes = $('.category-product-table .child-checkbox')
            // Array.from(checkboxes).forEach(checkbox => {
            //     if ($(checkbox).is(':checked')) {
            //         productIds.push($(checkbox).data().productId)
            //     }
            // });
            if (selectedProductIds.length > 0) {
                addProductFromIdArray(selectedProductIds)
            }
        })
        const addProductFromIdArray = (ids) => {
            $('#add-product-btn').loading()
            $.ajax({
                url: @json(route('admin.ajax.category.product.add', $category->id)),
                type: 'POST',
                data: {
                    productIds: ids
                },
                success: (res) => {
                    toast.success(`{{ trans('toast.action_successful') }}`, res.data.message)
                    $('.modal').modal('hide')
                    categoryTable.ajax.reload()
                },
                error: (err) => {
                    $('#add-product-btn').loading(false)
                }
            })
        }
    })()
</script>
