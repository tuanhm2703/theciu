<tr>
    <td class="product-col">
        <div class="product">
            <figure class="product-media">
                <a href="#">
                    <img src="{{ $inventory->image->path_with_domain }}" alt="Product image">
                </a>
            </figure>

            <h3 class="product-title">
                <a href="#"
                    class="{{ $inventory->pivot->quantity > $inventory->stock_quantity ? 'text-danger' : '' }}">{{ $inventory->product->name }}</a>
                @if ($inventory->pivot->quantity > $inventory->stock_quantity)
                    <br>
                    <small><i class="text-danger">Không đủ số lượng</i></small>
                @endif
            </h3><!-- End .product-title -->
        </div><!-- End .product -->
    </td>
    <td class="price-col">{{ $inventory->formatted_sale_price }}</td>
    <td class="quantity-col" wire:ignore>
        <div class="cart-product-quantity">
            <input type="number" class="form-control" min="1" max="10" step="1"
                data-decimals="0" wire:change="itemAdded({{ $inventory->id }}, $event.target.value)" data-inventory-id="{{ $inventory->id }}"
                value="{{ $inventory->pivot->quantity }}" required>
        </div><!-- End .cart-product-quantity -->
    </td>
    <td class="total-col">{{ format_currency($inventory->sale_price * $inventory->pivot->quantity) }}</td>
    <td class="remove-col" wire:click="$emit('cart:itemDeleted', {{ $inventory->id }})"><button class="btn-remove"><i
                class="icon-close"></i></button></td>
</tr>
