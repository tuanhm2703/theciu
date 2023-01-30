@if ($product->inventories->first()->attributes->count() > 1)
    <div class="details-filter-row details-row-size">
        <label for="size">{{ $product->inventories->first()->attributes->last()->name }}:</label>
        <div class="select-custom">
            <select name="size" id="size" class="form-control" wire:model="second_attribute_id">
                @foreach ($second_attributes as $index => $attribute)
                    <option value="{{ ((object) $attribute)->id }}">
                        {{ ((object) $attribute)->value }}</option>
                @endforeach
            </select>
        </div><!-- End .select-custom -->
    </div><!-- End .details-filter-row -->
@endif
<a class="size-guide" id="size-rule-gallery" href="{{ optional($product->size_rule_image)->path_with_domain }}"><i
    class="icon-th-list"></i>Hướng dẫn chọn size</a>
