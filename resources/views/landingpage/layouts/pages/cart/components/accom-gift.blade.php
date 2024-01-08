<tr>
    <td width="5%" class="p-3">
    </td>
    <td class="product-col" colspan="2quantity_each_order">
        <div class="product">
            <figure class="product-media mr-1">
                <a href="{{ optional($product->image)->path_with_domain }}" class="inventory-img-btn rounded"
                    style="background: url({{ optional($product->image)->path_with_domain }}); width: 50px; height: 50px; background-position: center; background-size: cover"></a>
            </figure>

            <h3 class="product-title d-flex flex-column">
                <a href="{{ route('client.product.details', $product->slug) }}">{{ $product->name }}</a>
            </h3><!-- End .product-title -->
        </div><!-- End .product -->
    </td>
    <td class="price-col" colspan="3">
        <select class="form-control border-0 p-0 mb-0 font-weight-bold" name="accom_inventory_id" id="" wire:model="accom_inventory_ids.{{ $index }}">
            @foreach ($product->inventories as $inventory)
                <option @checked($inventory->id == $accom_inventory_ids[$index]) value="{{ $inventory->id }}">{{ $inventory->title }} (x {{ $inventory->quantity_each_order }})</option>
            @endforeach
        </select>
    </td>
</tr>
