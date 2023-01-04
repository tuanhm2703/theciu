<div class="product-price">
    @if ($product->is_has_sale)
        <span class="new-price">₫{{ number_format($product->sale_price, 0, ',', '.') }}</span>
        <span class="old-price">₫{{ number_format($product->original_price, 0, ',', '.') }}</span>
    @else
        ₫{{ number_format($product->original_price, 0, ',', '.') }}
    @endif
</div>
