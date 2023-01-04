<div class="card {{ isset($cardClass) ? $cardClass : '' }}" {{isset($id) ? "id=$id" : ""}}>
    @isset($header)
        <div class="card-header {{ isset($headerClass) ? $headerClass : '' }}">
            <h6>{{ $header }}</h6>
        </div>
    @endisset
    <div class="card-body {{ isset($bodyClass) ? $bodyClass : '' }}">
        {{ $slot }}
    </div>
</div>
