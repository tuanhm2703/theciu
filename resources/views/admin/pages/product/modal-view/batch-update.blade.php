<div class="card card-plain">
    <div class="card-header pb-0 text-left">
        <h4 class="font-weight-bolder text-primary text-gradient">Cập nhật sản phẩm hàng loạt</h4>
    </div>
    <div class="card-body pb-3">
        <div class="nav-wrapper position-relative end-0">
            <div class="nav-wrapper position-relative end-0">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#download-tutorial"
                            role="tab" aria-controls="home" aria-selected="true">Tải bản mẫu</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#upload-batch" role="tab"
                            aria-controls="profile" aria-selected="false">Tải lên</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="download-tutorial" role="tabpanel" aria-labelledby="home-tab">
                        <p>
                            Vui lòng tải về bản mẫu bên dưới và cập nhật thông tin sản phẩm của bạn bằng tập tin
                            Microsoft Excel.
                        </p>
                        <div>
                            <h6>Bản mẫu</h6>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-check mb-3">
                                        {!! Form::radio('type', App\Services\BatchService::GENERAL_BATCH_UPDATE_TYPE, true, [
                                            'class' => 'form-check-input',
                                        ]) !!}
                                        <label for="type" data-html="true" class="custom-control-label"
                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                            title='{{ view('admin.pages.product.modal-view.general-info-tooltip') }}'
                                            data-container="body" data-animation="true" aria-hidden="true">Thông tin cơ
                                            bản</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-check mb-3">
                                        {!! Form::radio('type', App\Services\BatchService::SALE_BATCH_UPDATE_TYPE, null, [
                                            'class' => 'form-check-input',
                                        ]) !!}
                                        <label for="type" data-html="true" class="custom-control-label"
                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                            title='{{ view('admin.pages.product.modal-view.sale-info-tooltip') }}'
                                            data-container="body" data-animation="true" aria-hidden="true">Thông tin Bán
                                            hàng</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-check mb-3">
                                        {!! Form::radio('type', App\Services\BatchService::SHIPMENT_BATCH_UPDATE_TYPE, null, [
                                            'class' => 'form-check-input',
                                        ]) !!}
                                        <label for="type" data-html="true" class="custom-control-label"
                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                            title='{{ view('admin.pages.product.modal-view.shipment-info-tooltip') }}'
                                            data-container="body" data-animation="true" aria-hidden="true">Thông tin Vận
                                            chuyển</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-check mb-3">
                                        {!! Form::radio('type', App\Services\BatchService::IMAGE_BATCH_UPDATE_TYPE, null, [
                                            'class' => 'form-check-input',
                                        ]) !!}
                                        <label for="type" data-html="true" class="custom-control-label"
                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                            title='{{ view('admin.pages.product.modal-view.img-info-tooltip') }}'
                                            data-container="body" data-animation="true" aria-hidden="true">Hình
                                            ảnh</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-3">
                            <a href="#" id="download-file-btn" class="btn btn-primary">
                                Tải bản mẫu
                            </a>
                            <p>Bản mẫu cơ bản chứa các trường bắt buộc để liệt kê sản phẩm của bạn. Bản mẫu này có thể
                                được sử dụng cho bất kỳ ngành hàng nào</p>
                        </div>
                    </div>
                    <div class="tab-pane" id="upload-batch" role="tabpanel" aria-labelledby="profile-tab">
                        <p class="mb-0 mt-3l mt-3">Vui lòng kiểm tra đúng thông tin dữ liệu trước khi thực hiện thao
                            tác!</p>
                        {!! Form::open([
                            'url' => route('admin.ajax.product.batch_action.update'),
                            'method' => 'POST',
                            'class' => 'form batch-update-form mt-3',
                        ]) !!}
                        <div class="input-group mb-3 mt-3">
                            <input type="file" class="form-control filePond" name="file" placeholder="Name"
                                accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
                                aria-label="Name" required data-max-file-size="10MB" data-max-files="1"
                                aria-describedby="name-addon">
                        </div>
                        <div class="text-end mt-3">
                            <button class="btn btn-primary submit-btn">Cập nhật</button>
                        </div>
                        {!! Form::close() !!}
                        <div class="table-responsive">
                            <table class="table d-none updated-product-table">
                                <thead>
                                    <th>Mã sản phẩm</th>
                                    <th>Tên</th>
                                    <th>SKU</th>
                                    <th>Hình ảnh</th>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    (() => {
        FilePond.registerPlugin();

        const pond = FilePond.create(document.querySelector('.filePond'), {
            storeAsFile: true,
            labelIdle: 'Kéo thả file hoặc <span class="filepond--label-action"> Chọn </span>'
        });
        $('.batch-update-form').on('submit', (event) => {
            event.preventDefault()
            const form = $('.batch-update-form')
            let formData = new FormData(form[0])
            formData.append('file', pond.getFile(1))
            $('.submit-btn').loading()
            $.ajax({
                url: form.attr('action'),
                method: form.attr('method'),
                data: formData,
                dataType: 'json',
                contentType: false,
                processData: false,
                success: (res) => {
                    toast.success(`{{ trans('toast.action_successful') }}`, res.data.message)
                    initUpdatedProductTable(res.data.product_ids)
                    $('.submit-btn').loading(false)
                    pond.removeFiles()
                    // table.ajax.reload()
                },
                error: (err) => {
                    $('.submit-btn').loading(false)
                }
            })
        })
        const initUpdatedProductTable = (productIds = []) => {
            $('.updated-product-table').removeClass('d-none')
            $('.updated-product-table').DataTable({
                "processing": true,
                "serverSide": true,
                "destroy": true,
                "ajax": {
                    url: "{{ route('admin.ajax.product.paginate') }}",
                    type: "GET",
                    data: function(d) {
                        console.log(productIds);
                        d.ids = productIds;
                    }
                },
                "columns": [{
                        data: "id"
                    },
                    {
                        data: "name"
                    },
                    {
                        data: "sku"
                    },
                    {
                        data: "image_list"
                    }
                ]
            })
        }
        $('#download-file-btn').on('click', (e) => {
            window.location.href =
                `{{ route('admin.ajax.product.batch_action.file') }}?type=${$('input[name=type]:checked').val()}`
        })
    })()
</script>
