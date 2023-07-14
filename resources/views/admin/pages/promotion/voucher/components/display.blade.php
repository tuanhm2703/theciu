@if ($voucher->display === App\Enums\DisplayType::PRIVATE)
<span class="badge bg-gradient-primary">{{ $voucher->display }}</span>
@elseif ($voucher->display === App\Enums\DisplayType::SYSTEM)
<span class="badge bg-gradient-info">{{ $voucher->display }}</span>
@else
<span class="badge bg-gradient-success">{{ $voucher->display }}</span>
@endif
