@if ($product->inventories->first()->attributes->count() > 1)
    <div class="details-filter-row details-row-size">
        <label for="size">{{ $product->inventories->first()->attributes->last()->name }}:</label>
        <div>
            @foreach ($second_attributes as $index => $attribute)
                @php
                    $attribute = (object) $attribute;
                @endphp
                <div class="radio-container" wire:ignore>
                    <input wire:change="changeSecondAttributeId({{ $attribute->id }})" name="second_attribute_value"
                        id="second-attribute-{{ $attribute->value }}" type="radio" class="square-radio-input"
                        wire:model="second_attribute_value" value="{{ $attribute->value }}">
                    <label for="second-attribute-{{ $attribute->value }}" class="radio">{{ $attribute->value }}</label>
                </div>
            @endforeach
            {{-- <select name="size" id="size" class="form-control" wire:model="second_attribute_id">
                @foreach ($second_attributes as $index => $attribute)
                    <option value="{{ ((object) $attribute)->id }}">
                        {{ ((object) $attribute)->value }}</option>
                @endforeach
            </select> --}}
        </div><!-- End .select-custom -->
    </div><!-- End .details-filter-row -->
@endif
<a href="#" id="size-guide-gallery">
    <i class="icon-th-list"></i>{{ trans('labels.size_guide') }} <br>
</a>
<div class="mt-1">
    @foreach ($product->size_rule_images as $image)
        <a style="background: url({{ $image->path_with_domain }})" class="size-rule-gallery img-thumbnail"
            href="{{ $image->path_with_domain }}"></a>
    @endforeach
</div>

{{-- <div id="size-rule-gallery">
    @foreach ($product->size_rule_images as $image)
        <a class="size-rule-item" href="{{ $image->path_with_domain }}"></a>
    @endforeach
</div> --}}
