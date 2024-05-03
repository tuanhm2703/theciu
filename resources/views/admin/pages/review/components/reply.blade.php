<small class="text-body-secondary">Mã đơn hàng: {{ $review->order?->order_number }}</small>
<br>
@if ($review->reply)
    <div class="fr-view">
        <p style="width: 300px; white-space: break-spaces;">{!! $review->reply !!}</p>
    </div>
    <small class="text-body-secondary d-block">{{ $review->updated_at->format('H:i d/m/Y') }}</small>
    <a class="ajax-modal-btn" href="javascript:void(0)" data-modal-size="modal-md"
        data-link="{{ route('admin.review.reply.edit', $review->id) }}"><i class="text-info">Cập nhật</i></a>
@else
        <a class="ajax-modal-btn" href="javascript:void(0)" data-modal-size="modal-md"
        data-link="{{ route('admin.review.reply.edit', $review->id) }}"><i class="text-info">Trả lời</i></a>
@endif
