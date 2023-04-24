<div class="card card-plain">
    <div class="card-header pb-0 text-left">
        <h4 class="font-weight-bolder text-primary text-gradient">Tạo sản phẩm hàng loạt</h4>
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
                        <div class="mt-3">
                            <a href="/docs/the-ciu-batch-file-sample.xlsx" class="btn btn-primary">
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
                            'url' => route('admin.ajax.product.create_from_file'),
                            'method' => 'POST',
                            'class' => 'form batch-create-form mt-3',
                        ]) !!}
                        <div class="input-group mb-3 mt-3">
                            <input type="file" class="form-control filePond" name="batch-create-file"
                                placeholder="Name"
                                accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
                                aria-label="Name" required data-max-file-size="10MB" data-max-files="1"
                                aria-describedby="name-addon">
                        </div>
                        <div class="text-end mt-3">
                            <button class="btn btn-primary submit-btn">Tạo hàng loạt</button>
                        </div>
                        {!! Form::close() !!}
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
        $('.batch-create-form').on('submit', (event) => {
            event.preventDefault()
            const form = $('.batch-create-form')
            let formData = new FormData(form[0])
            formData.append('batch-create-file', pond.getFile(1))
            $('.submit-btn').loading()
            $.ajax({
                url: form.attr('action'),
                method: form.attr('method'),
                data: formData,
                dataType: 'json',
                contentType: false,
                processData: false,
                success: (res) => {
                    toast.success(`{{trans('toast.action_successful')}}`, res.data.message)
                    setTimeout(() => {
                        $('.batch-create-form').parents('.modal').modal('hide')
                        table.ajax.reload()
                    }, 1000);
                },
                error: (err) => {
                    $('.submit-btn').loading(false)
                }
            })
        })
    })()
</script>
