<div class="container">
    <h2 class="title text-center mb-4">New Arrivals</h2><!-- End .title text-center -->

    <div class="products">
        <div class="row justify-content-center">
            @foreach ($products as $product)
                <div class="col-12 col-md-4 col-lg-3">
                    @component('components.client.product-card', compact('product'))
                    @endcomponent
                </div><!-- End .col-sm-6 col-md-4 col-lg-3 -->
            @endforeach
        </div><!-- End .row -->
    </div><!-- End .products -->

    <div class="more-container text-center mt-2">
        @if ($hasNext)
            <a href="#" class="btn btn-outline-dark-2 btn-more" wire:click.prevent="loadMore()">
                <div wire:loading class="spinner-border" role="status">
                    <span class="sr-only">Loading...</span>
                  </div>
                <span wire:loading.remove>Xem thêm</span></a>
        @else
        @endif
    </div><!-- End .more-container -->
</div><!-- End .container -->
