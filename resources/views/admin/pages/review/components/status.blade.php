<div class="text-center">
    @if ($review->status === App\Enums\StatusType::ACTIVE)
    <span class="badge bg-gradient-success">Hiện</span>
@else
    <span class="badge bg-gradient-danger">Ẩn</span>
@endif

</div>
