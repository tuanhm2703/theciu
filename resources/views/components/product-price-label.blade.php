<div class="product-price">
    @if (isset($inventory) && $inventory)
        @if ($inventory->price > $inventory->sale_price)
            <span class="new-price">{{ number_format($inventory->sale_price, 0, ',', '.') }}</span>
            <span class="old-price">{{ number_format($inventory->price, 0, ',', '.') }}</span>
        @else
            {{ format_currency_with_label($inventory->price, 0, ',', '.') }}
        @endif
    @elseif ($product->is_has_sale)
        <span class="new-price">{{ number_format($product->sale_price, 0, ',', '.') }}</span>
        <span class="old-price">{{ number_format($product->original_price, 0, ',', '.') }}</span>
    @else
        {{ format_currency_with_label($product->original_price, 0, ',', '.') }}
    @endif
</div>
