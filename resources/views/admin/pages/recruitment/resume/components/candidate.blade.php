<div>
    <p class="m-0"><strong>{{ $resume->fullname }}</strong></p>
    <p>
        @if ($resume->viewed)
            <span class="badge bg-gradient-success" style="font-size: 9px">Đã xem</span>
        @else
            <span class="badge bg-gradient-secondary" style="font-size: 9px">Chưa xem</span>
        @endif
    </p>
</div>
