@foreach ($product->inventories as $inventory)
    <p class="text-sm font-weight-bold mb-0">{{ implode(', ', $inventory->attributes->pluck('pivot.value')->toArray()) }}</p>
@endforeach
