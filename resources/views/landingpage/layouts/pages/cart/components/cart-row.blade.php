<tr>
    <td class="product-col">
        <div class="product">
            <figure class="product-media">
                <a href="#">
                    <img src="{{ $inventory->image->path_with_domain }}" alt="Product image">
                </a>
            </figure>

            <h3 class="product-title">
                <a href="#">{{ $inventory->product->name }}</a>
            </h3><!-- End .product-title -->
        </div><!-- End .product -->
    </td>
    <td class="price-col">{{ $inventory->formatted_sale_price }}</td>
    <td class="quantity-col">
        <div class="cart-product-quantity">
            <input type="number" class="form-control" value="{{ $inventory->pivot->quantity }}" min="1"
                max="{{ $inventory->stock_quantity }}" step="1" data-decimals="0" required>
        </div><!-- End .cart-product-quantity -->
    </td>
    <td class="total-col">{{ format_currency($inventory->sale_price * $inventory->pivot->quantity) }}</td>
    <td class="remove-col"><button class="btn-remove"><i class="icon-close"></i></button></td>
</tr>
