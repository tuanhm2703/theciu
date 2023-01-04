@if ($product->inventories->first()->attributes->count() > 1)
    @php
        $second_attrbutes = [];
        foreach ($product->inventories as $inventory) {
            $second_attributes[] = $inventory->attributes->last();
        }
    @endphp
    <div class="details-filter-row details-row-size">
        <label for="size">{{ $product->inventories->first()->attributes->last()->name }}:</label>
        <div class="select-custom">
            <select name="size" id="size" class="form-control">
                @foreach ($second_attributes as $index => $attribute)
                    <option value="{{ $attribute->pivot->inventory_id }}" selected="{{ $index === 0 ? 'selected' : '' }}">
                        {{ $attribute->pivot->value }}</option>
                @endforeach
            </select>
        </div><!-- End .select-custom -->
        <a class="size-guide" id="size-rule-gallery" href="{{ optional($product->size_rule_image)->path_with_domain }}"><i
                class="icon-th-list"></i>Hướng dẫn chọn size</a>
    </div><!-- End .details-filter-row -->
@endif
