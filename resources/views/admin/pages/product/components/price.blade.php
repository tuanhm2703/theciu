@foreach ($product->inventories as $inventory)
    <p class="text-sm font-weight-bold mb-0">{{ $inventory->formatted_price }}</p>
@endforeach
