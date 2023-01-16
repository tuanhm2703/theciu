
<div class="details-filter-row details-row-size">
    <label>{{ $product->inventories->first()->attributes->first()->name }}:</label>
    @php
        $imgPaths = [];
        foreach ($product->inventories as $i) {
            if ($i->image) {
                $imgPaths[] = $i->image->path_with_domain;
            }
        }
        $imgPaths = array_unique($imgPaths);
    @endphp
    <div class="product-nav product-nav-thumbs">
        @foreach ($imgPaths as $path)
            <a href="#">
                <img src="{{ $path }}" alt="product desc">
            </a>
        @endforeach
    </div><!-- End .product-nav -->
</div><!-- End .details-filter-row -->

