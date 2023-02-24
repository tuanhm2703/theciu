<div>
    <div class="row">
        @foreach ($products as $product)
            <div class="col-6 col-md-4 col-lg-3">
                <livewire:client.product-card-component wire:key="order-product={{ $product->id }}" :product="$product">
                </livewire:client.product-card-component>
            </div><!-- End .col-sm-6 col-md-4 col-lg-3 -->
        @endforeach
    </div>

    <div class="text-center">
        @if ($hasNext)
            <a href="#" class="btn btn-outline-dark-2 btn-more" wire:click.prevent="nextPage()">
                <div wire:loading class="spinner-border" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
                <span wire:loading.remove>Xem thêm</span>
            </a>
        @else
        @endif
    </div>
</div>
