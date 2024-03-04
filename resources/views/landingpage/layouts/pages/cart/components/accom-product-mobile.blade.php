<div class="row mt-2">
    <div class="col-2 col-md-1">
        <input wire:change="updateOrderInfo" type="checkbox"
        @disabled(count($accom_product_selected) >= $promotion->num_of_products && !in_array($product->id, $accom_product_selected))
        class="form-control custom-checkbox m-auto check-cart-item p-1" value="{{ $product->id }}"
        wire:model="accom_product_selected">
    </div>
    <div class="col-9 col-md-10">
        <div class="product-col">
            <div class="cart-product px-2">
                <figure class="product-media mr-1">
                    <img src="{{ optional($product->image)->path_with_domain }}" alt="">
                </figure>
            </div>

            <div>
                <h3 class="product-title mb-1">
                    <a href="{{ route('client.product.details', $product->slug) }}">{{ $product->name }}</a>
                </h3><!-- End .product-title -->
                <div class="form-group mb-1">
                    <label class="mb-0" for="inventory_id">Thuộc tính</label>
                    <select name="inventory_id" class="p-0 mb-0 w-75 form-control" id="" wire:model="accom_product_inventory_ids.{{ $index }}">
                        @foreach ($product->inventories as $inventory)
                            <option value="{{ $inventory->id }}">{{ $inventory->title }} (x {{ $inventory->quantity_each_order }})</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div><!-- End .product -->
    </div>
</div>
