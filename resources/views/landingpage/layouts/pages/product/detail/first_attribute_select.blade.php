<div class="details-filter-row details-row-size">
    <label>{{ $product->inventories->first()->attributes->first()->name }}:</label>
    @php

    @endphp
    <div class="product-nav product-nav-thumbs">
        @foreach ($first_attributes as $attribute)
            <a href="#" wire:model="first_attribute_id"
                wire:click.prevent="changeFirstAttributeId({{ ((object) $attribute)->id }})">
                <img src="{{ ((object) $attribute)->path }}" alt="product desc">
            </a>
        @endforeach
    </div><!-- End .product-nav -->
</div><!-- End .details-filter-row -->
