@foreach ($product->inventories as $inventory)
    <p class="text-sm font-weight-bold mb-0 text-center">{{ $inventory->stock_quantity }}</p>
@endforeach
