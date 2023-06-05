<div class="form-check text-center form-check-info">
    <input type="checkbox" data-product-id="{{ $product->id }}" @if (in_array($product->id, $selected))
        checked
    @endif class="editor-active form-check-input child-checkbox">
</div>
