@foreach ($product->inventories as $inventory)
    <p class="text-sm font-weight-bold mb-0">{{ $inventory->sku }} <small class="text-danger">{{ $inventory->status ? '' : '(Chưa đồng bộ Kiot)' }}</small></p>
@endforeach
