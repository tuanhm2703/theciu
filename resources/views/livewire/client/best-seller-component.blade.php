<div class="container mt-5 heading" wire:init="loadContent">
    @if ($readyToLoad)
        <h2 class="title text-center mb-4">Best Seller</h2><!-- End .title text-center -->

        <div class="products">
            <div class="row justify-content-center">
                @foreach ($products as $product)
                    <div class="col-6 col-md-4 col-lg-3">
                        <livewire:client.product-card-component wire:key="product-new-arrival-{{ $product->id }}"
                            :product="$product"></livewire:client.product-card-component>
                    </div><!-- End .col-sm-6 col-md-4 col-lg-3 -->
                @endforeach
            </div><!-- End .row -->
        </div><!-- End .products -->

        <div class="more-container text-center mt-2">
            @if ($hasNext)
                <a href="#" class="btn btn-more" wire:click.prevent="loadMore()">
                    <div wire:loading class="spinner-border" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                    <span wire:loading.remove>Xem thêm</span>
                </a>
            @else
            @endif
        </div><!-- End .more-container -->
    @else
        <div class="d-flex justify-content-center h-100">
            <div wire:loading>
                <div class="spinner-grow" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
                <div class="spinner-grow" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
                <div class="spinner-grow" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
        </div>
    @endif
</div><!-- End .container -->
