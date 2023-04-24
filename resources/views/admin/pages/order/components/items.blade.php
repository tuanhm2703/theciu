@foreach ($order->inventories as $inventory)
    <div class="row mb-2">
        <div class="col-2">
            <a href="#" class="magnifig-img product-img img-thumbnail mx-1"
                style="background: url({{ optional($inventory->image)->path_with_domain }})"></a>
        </div>
        <div class="col-8" style="line-height: 0">
            <p data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $inventory->pivot->name }}"
                class="cut-text text-bold">{{ $inventory->pivot->name }}</p>
            <span>{{ $inventory->pivot->title }}</span>
        </div>
        <div class="col-2">
            <span class="text-sm">{{ $inventory->pivot->quantity }}x</span>
        </div>
    </div>
@endforeach
@if ($order->note)
    <div class="mx-1 mt-3 w-100">
        <i style="white-space: normal;">Chú thích: {{ $order->note }}</i>
    </div>
@endif
