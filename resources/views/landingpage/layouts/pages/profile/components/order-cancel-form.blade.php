<div class="px-5 my-5">
    <h5>Lý do huỷ</h5>
    {!! Form::model($order, [
        'url' => route('client.auth.profile.order.cancel', ['order' => $order->id]),
        'method' => 'PUT',
        'id' => 'cancelOrderForm',
    ]) !!}
    <div class="cancel-warning-box d-flex justify-content-center">
        <div class="icon-wrapper w-10">
            <i class="far fa-bell"></i>
        </div>
        <div class="description w-90">
            <p>Bạn có biết? Bạn có thể cập nhật thông tin nhận hàng cho đơn hàng (1 lần duy nhất). Nếu bạn xác nhận hủy,
                toàn bộ đơn hàng sẽ được hủy. Trường hợp bạn đã thanh toán đơn hàng, tiền sẽ được hoàn về Ví Momo.</p>
        </div>
    </div>
    <div class="cancel-reason-group">
        <div class="custom-control custom-radio">
            <input type="radio" name="cancel_reason" value="Tôi muốn cập nhật địa chỉ/sđt nhận hàng" checked
                id="cancel-reason-1" class="custom-control-input">
            <label for="cancel-reason-1"
                class="custom-control-label">Tôi muốn cập nhật địa chỉ/sđt nhận hàng</label>
        </div><!-- End .custom-control -->
        <div class="custom-control custom-radio">
            <input type="radio" name="cancel_reason" value="Người bán không trả lời thắc mắc / yêu cầu của tôi"
                id="cancel-reason-2" class="custom-control-input">
            <label for="cancel-reason-2"
                class="custom-control-label">Người bán không trả lời thắc mắc / yêu cầu của tôi</label>
        </div><!-- End .custom-control -->
        <div class="custom-control custom-radio">
            <input type="radio" name="cancel_reason" value="Thay đổi đơn hàng (màu sắc, kích thước, thêm mã giảm giá,...)"
                id="cancel-reason-3" class="custom-control-input">
            <label for="cancel-reason-3"
                class="custom-control-label">Thay đổi đơn hàng (màu sắc, kích thước, thêm mã giảm giá,...)</label>
        </div><!-- End .custom-control -->
        <div class="custom-control custom-radio">
            <input type="radio" name="cancel_reason" value="Tôi không có nhu cầu mua nữa"
                id="cancel-reason-4" class="custom-control-input">
            <label for="cancel-reason-4"
                class="custom-control-label">Tôi không có nhu cầu mua nữa</label>
        </div><!-- End .custom-control -->
    </div>
    <div class="text-right">
        <button type="submit" class="btn btn-primary">Huỷ đơn hàng</button>
    </div>
    {!! Form::close() !!}
</div>
<script>
    $('#cancelOrderForm').ajaxForm({
        beforeSend: () => {
            $('#cancelOrderForm button[type=submit]').loading()
        },
        success: (res) => {
            tata.success(@json(trans('toast.action_successful')), res.data.message);
            setTimeout(() => {
                window.location.reload()
            }, 1000);
        },
        error: (err) => {

        }
    })
</script>
