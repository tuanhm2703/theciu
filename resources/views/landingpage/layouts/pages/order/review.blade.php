{!! Form::open([
    'url' => route('client.review.store'),
    'method' => 'POST',
    'id' => 'review-form',
    'style' => 'max-height: 90vh; overflow: scroll',
    'enctype' => 'multipart/form-data',
]) !!}
<div class="card p-5 review-form">
    <div class="bg-white card-header position-sticky py-3" style="top: 0; z-index: 1">
        <h5><span class="d-inline" data-dismiss="modal" aria-label="Close" aria-hidden="true"><i
                    class="fas fa-angle-left mr-3"></i></span>Đánh giá sản phẩm</h5>
    </div>
    {!! Form::hidden('order_id', $order->id, ['class' => 'order_id']) !!}
    <div class="card-body p-0">
        <div class="row mb-3 md-mb-0">
            <div class="col-12 col-md-4 md-mb-3">
                <h6 class="mb-0">Chất lượng sản phẩm</h6>
            </div>
            <div class="col-12 col-md-8 md-mb-3">
                <div class="product-rate rating"></div>
            </div>
        </div>
        @foreach ($order->inventories as $inventory)
            <div class="d-flex">
                <div class="mr-3">
                    <img src="{{ $inventory->image->path_with_domain }}" alt="" width="50px">
                </div>
                <div>
                    <h6 class="mb-1">{{ $inventory->name }}</h6>
                    <p>Phân loại hàn: {{ $inventory->title }}</p>
                </div>
            </div>
        @endforeach
        <div class="bg-light p-3 mt-3">
            <div class="p-3 border bg-white">
                <div class="form-group mb-1">
                    <label for="color" class="mb-0 font-weight-bold">Màu sắc</label>
                    <input type="text" name="color" class="form-control border-0 pl-0"
                        placeholder="Để lại đánh giá">
                </div>
                <div class="form-group mb-1">
                    <label for="reality" class="mb-0 font-weight-bold">Đúng với mô tả</label>
                    <input name="reality" type="text" class="form-control border-0 pl-0">
                </div>
                <div class="form-group mb-1">
                    <label for="material" class="mb-0 font-weight-bold">Chất liệu</label>
                    <input name="material" type="text" class="form-control border-0 pl-0">
                </div>
                <div class="form-group border-top">
                    <textarea name="details" class="form-control border-0 pl-0"
                        placeholder="Hãy chia sẻ những điều bạn thích về sản phẩm này với những người mua khác nhé."></textarea>
                </div>
            </div>
            <div class="row mt-1">
                <div class="col-12 col-md-6">
                    <input type="file" name="images" multiple>
                </div>
                <div class="col-12 col-md-6">
                    <input type="file" name="video" multiple data-max-file-size="10MB">
                </div>
            </div>
        </div>
        <div class="d-flex mt-3">
            <div class="pr-3">
                <input name="display" value="{{ \App\Enums\DisplayType::PUBLIC }}" type="checkbox"
                    class="form-control custom-checkbox m-auto check-cart-item m-0">
            </div>
            <div class="d-flex flex-column justify-content-center">
                <h6 class="mb-0">Hiển thị tên đăng nhập trên đánh giá này</h6>
                <p>Tên tài khoản sẽ được hiển thị như henry1259</p>
            </div>
        </div>
        <h6 class="mt-3">Về dịch vụ</h6>
        <div class="row mb-1 md-mb-0">
            <div class="col-12 col-md-4 md-mb-3">
                <label class="mb-0">Dịch vụ tư vấn</label>
            </div>
            <div class="col-12 col-md-8 md-mb-3">
                <div class="customer-service-rate rating"></div>
            </div>
        </div>
        <div class="row mb-3 md-mb-0">
            <div class="col-12 col-md-4 md-mb-3">
                <label class="mb-0">Dịch vụ vận chuyển</label>
            </div>
            <div class="col-12 col-md-8 md-mb-3">
                <div class="shipping-service-rate rating"></div>
            </div>
        </div>
    </div>
    <div class="mt-3 text-right position-sticky bg-white py-3" style="bottom: 0">
        <button type="submit" class="submit-btn btn btn-primary">Hoàn thành</button>
    </div>
</div>
{!! Form::close() !!}
<script>
    (() => {
        const images = FilePond.create(document.querySelector('input[name=images]'), {
            imagePreviewHeight: 50,
            storeAsFile: true,
            files: [],
            labelIdle: '<label>Upload hình ảnh</label>',
            maxFiles: 5,
            required: true,
            maxFileSize: '5mb',
            acceptedFileTypes: ['image/*'],
        })
        const video = FilePond.create(document.querySelector('input[name=video]'), {
            imagePreviewHeight: 50,
            allowVideoPreview: true,
            storeAsFile: true,
            acceptedFileTypes: ['video/*'],
            files: [],
            labelIdle: '<label>Upload video</label>',
            maxFiles: 1,
            maxFileSize: '10MB',
            labelMaxFileSizeExceeded: 'Video quá lớn, vui lòng sử dụng video dưới 10MB'
        })
        $('.product-rate').starRating({
            initialRating: 100,
            starIconEmpty: 'far fa-star',
            wrapperClasses: '.product-rate',
            starIconFull: 'fas fa-star',
            starColorEmpty: 'lightgray',
            starColorFull: '#FFC107',
            starsSize: 2, // em
            stars: 5,
            initStar: 5,
            inputName: 'product_score',
            titles: ["Tệ", "Không hài lòng", "Bình thường", "Hài lòng", "Tuyệt vời"],
        });
        $('.customer-service-rate').starRating({
            initialRating: 5,
            wrapperClasses: '.customer-service-rate',
            starIconEmpty: 'far fa-star',
            starIconFull: 'fas fa-star',
            starColorEmpty: 'lightgray',
            starColorFull: '#FFC107',
            starsSize: 2, // em
            stars: 5,
            initStar: 5,
            inputName: 'customer_service_score',
            titles: ["Tệ", "Không hài lòng", "Bình thường", "Hài lòng", "Tuyệt vời"],
        });
        $('.shipping-service-rate').starRating({
            initialRating: 5,
            wrapperClasses: '.shipping-service-rate',
            starIconEmpty: 'far fa-star',
            starIconFull: 'fas fa-star',
            starColorEmpty: 'lightgray',
            starColorFull: '#FFC107',
            starsSize: 2, // em
            stars: 5,
            initStar: 5,
            inputName: 'shipping_service_score',
            titles: ["Tệ", "Không hài lòng", "Bình thường", "Hài lòng", "Tuyệt vời"],
        });
        $('#review-form').ajaxForm({
            beforeSend: function(xhr, options) {
                $('#review-form .submit-btn').loading()
                var formData = new FormData($('#review-form')[0]);
                images.getFiles().forEach((element, index) => {
                    formData.append(`images[${index}]`, element.file);
                });
                options.data = formData;
            },
            success: (res) => {
                $('.modal').modal('hide')
                toast.success(`{{ trans('toast.action_successful') }}`, res.data.message);
                $('[data-review-order-id={{ $order->id }}]').remove()
                if (res.data.voucher_view) {
                    $('#review-voucher-gift').html(res.data.voucher_view)
                    $('#review-voucher-gift').removeClass('d-none')
                    $.magnificPopup.open({
                        items: {
                            src: "#review-voucher-gift",
                        },
                        type: "inline",
                        removalDelay: 350,
                        callbacks: {
                            open: function() {
                                $("body").css("overflow-x", "visible");
                                $(".sticky-header.fixed").css(
                                    "padding-right",
                                    "1.7rem"
                                );
                                setTimeout(() => {
                                    $('.voucher-popup').css('opacity', 1)
                                }, 500);
                            },
                            close: function() {
                                $("body").css("overflow-x", "hidden");
                                $(".sticky-header.fixed").css("padding-right", "0");
                            },
                        },
                    });
                }
            },
            error: (err) => {
                $('#review-form .submit-btn').loading(false)
                var form = $('#review-form').initValidator()
                if (err.status === 422) {
                    const errors = err.responseJSON.errors;
                    Object.keys(err.responseJSON.errors).forEach((key) => {
                        form.errorTrigger(
                            $(`#review-form [name=${key}]`),
                            errors[key][0]
                        );
                    });
                }
            }
        })
    })()
</script>
