<div class="details-filter-row details-row-size">
    <label>{{ $product->inventories->first()->attributes->first()->name }}:</label>
    <div>
        @foreach ($first_attributes as $attribute)
            @php
                $attribute = (object) $attribute;
            @endphp
            <div class="radio-container">
                <input wire:change="changeFirstAttributeId({{ $attribute->id }})" name="first_attribute_value"
                    id="first-attribute-{{ $attribute->value }}" type="radio" class="square-radio-input"
                    wire:model="first_attribute_value" value="{{ $attribute->value }}">
                <label for="first-attribute-{{ $attribute->value }}" class="radio check-product-thumb-image carousel-dot" data-bs-toggle="tooltip" data-bs-placement="top"
                    data-html="true" title="<div><img width='70px' src='{{ $attribute->path }}'/> <div class='text-center py-2'>{{ $attribute->value }}</div></div>"
                    data-hash="#{{ $attribute->image_name }}"
                    data-image="{{ $attribute->path }}">{{ $attribute->value }}</label>
            </div>
        @endforeach
        {{-- @foreach ($first_attributes as $attribute)
            <a href="#" wire:model="first_attribute_id"
                wire:click.prevent="changeFirstAttributeId({{ ((object) $attribute)->id }})">
                <img src="{{ ((object) $attribute)->path }}" alt="product desc">
            </a>
        @endforeach --}}
    </div><!-- End .product-nav -->
</div><!-- End .details-filter-row -->
