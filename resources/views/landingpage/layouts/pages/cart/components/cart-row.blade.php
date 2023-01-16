<tr>
    <td class="product-col">
        <div class="product">
            <figure class="product-media">
                <a href="#">
                    <img src="{{ $inventory->image->path_with_domain }}" alt="Product image">
                </a>
            </figure>

            <h3 class="product-title">
                <a href="#" class="{{$inventory->pivot->quantity > $inventory->stock_quantity ? 'text-danger' : ''}}">{{ $inventory->product->name }}</a>
                @if($inventory->pivot->quantity > $inventory->stock_quantity)
                    <br>
                    <small><i class="text-danger">Không đủ số lượng</i></small>
                @endif
            </h3><!-- End .product-title -->
        </div><!-- End .product -->
    </td>
    <td class="price-col">{{ $inventory->formatted_sale_price }}</td>
    <td class="quantity-col">
        <div class="cart-product-quantity">
            <input class="number-input form-control inventory-quantity-input" data-inventory-id="{{ $inventory->id }}"
                wire:change="itemAdded({{ $inventory->id }}, $event.target.value)"
                value="{{ $inventory->pivot->quantity }}" required>
        </div><!-- End .cart-product-quantity -->
    </td>
    <td class="total-col">{{ format_currency($inventory->sale_price * $inventory->pivot->quantity) }}</td>
    <td class="remove-col" wire:click="$emit('cart:itemDeleted', {{ $inventory->id }})"><button class="btn-remove"><i
                class="icon-close"></i></button></td>
</tr>
