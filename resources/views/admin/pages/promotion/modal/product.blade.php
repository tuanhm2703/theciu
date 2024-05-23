<div class="card card-plain">
    <div class="card-header pb-0 d-flex justify-content-between">
        <h5 class="font-weight-bolder text-primary text-gradient">Danh sách sản phẩm</h5>
    </div>
    <div class="card-body pb-3">
        <div class="nav-wrapper position-relative end-0">
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
                            <table class="promotion-product-table table w-100">
                                <thead>
                                    <th style="padding-left: 0.5rem">
                                        <div class="form-check form-check-info">
                                            <input type="checkbox"
                                                class="editor-active form-check-input mass-checkbox-btn">
                                        </div>
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
                                <a href="{{ route('admin.ajax.product.batch_action.file', ['type' => App\Services\BatchService::UPDATE_PRODUCT_SALE_PRICE]) }}"
                                    class="btn btn-primary">
                                    <i class="fas fa-download"></i> Tải về bản mẫu
                                </a>
                            </div>
                        </div>
                        <div>
                            {!! Form::open([
                                'url' => route('admin.ajax.product.batch_action.update'),
                                'method' => 'POST',
                                'id' => 'batch-update-sale-form',
                            ]) !!}
                            <input type="file" name="product-id-list-file" class="filePond">
                            <div class="text-end">
                                <button type="submit" class="btn btn-primary">Cập nhật</button>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    (() => {
        let tempIdList = [...productIds]
        $('.promotion-product-table').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                url: "{{ route('admin.ajax.promotion.product.paginate') }}",
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
        const pond = FilePond.create(document.querySelector('.filePond'), {
            storeAsFile: true,
            labelIdle: 'Kéo thả file hoặc <span class="filepond--label-action"> Chọn </span>'
        });
        $('.promotion-product-table').on('change', '.child-checkbox', (e) => {
            const checkboxes = $('.promotion-product-table .child-checkbox')
            Array.from(checkboxes).forEach(checkbox => {
                if ($(checkbox).is(':checked')) {
                    tempIdList.push($(checkbox).data().productId)
                }
            });
            tempIdList = Array.from(new Set(tempIdList))
        })
        $('.promotion-product-table').on('click', '.mass-checkbox-btn', (e) => {
            const checkboxes = $('.promotion-product-table .child-checkbox')
            Array.from(checkboxes).forEach(checkbox => {
                if ($(checkbox).is(':checked')) {
                    tempIdList.push($(checkbox).data().productId)
                }
            });
            tempIdList = Array.from(new Set(tempIdList))
        })
        $('#add-product-btn').on('click', (e) => {
            e.preventDefault()
            const checkboxes = $('.promotion-product-table .child-checkbox')
            Array.from(checkboxes).forEach(checkbox => {
                if ($(checkbox).is(':checked')) {
                    productIds.push($(checkbox).data().productId)
                }
            });
            productIds = Array.from(new Set(productIds))
            renderPromotionSetting()
            $('.modal').modal('hide')
        })
        $('#batch-update-sale-form').on('submit', (event) => {
            event.preventDefault()
            const form = $('#batch-update-sale-form')
            let formData = new FormData(form[0])
            formData.append('file', pond.getFile().file)
            $("#batch-update-sale-form button[type=submit]").loading()
            $.ajax({
                url: form.attr('action'),
                method: form.attr('method'),
                data: formData,
                dataType: 'json',
                contentType: false,
                processData: false,
                success: (res) => {
                    // toast.success(`{{ trans('toast.action_successful') }}`, res.data.message)
                    $("#batch-update-sale-form button[type=submit]").loading(false)
                    products = res.data.product_ids
                    renderPromotionSettingForm()
                    pond.removeFiles()
                },
                error: (err) => {
                    $("#batch-update-sale-form button[type=submit]").loading(false)
                }
            })
        })
    })()
</script>
