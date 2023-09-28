@if ($product->inventories->first()->attributes->count() > 1)
    <div class="details-filter-row details-row-size">
        <label for="size">{{ $product->inventories->first()->attributes->last()->name }}:</label>
        <div>
            @foreach ($second_attributes as $index => $attribute)
                @php
                    $attribute = (object) $attribute;
                @endphp
                <div class="radio-container">
                    <input wire:change="changeSecondAttributeValue('{{ $attribute->value }}')" name="second_attribute_value"
                        id="second-attribute-{{ $attribute->value }}" type="radio" class="square-radio-input" value="{{ $attribute->value }}">
                    <label @disabled($attribute->out_of_stock) for="second-attribute-{{ $attribute->value }}" class="radio inventory-picker">{{ json_decode($attribute->origin_value) }}</label>
                </div>
            @endforeach
        </div><!-- End .select-custom -->
    </div><!-- End .details-filter-row -->
@endif
