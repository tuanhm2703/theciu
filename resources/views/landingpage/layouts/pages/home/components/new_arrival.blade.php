<div class="container">
    <h2 class="title text-center mb-4">New Arrivals</h2><!-- End .title text-center -->

    <div class="products">
        <div class="row justify-content-center">
            @foreach ($new_arrival_products as $product)
                <div class="col-6 col-md-4 col-lg-3">
                    <livewire:client.product-card-component :product="$product"></livewire:client.product-card-component>
                </div><!-- End .col-sm-6 col-md-4 col-lg-3 -->
            @endforeach
        </div><!-- End .row -->
    </div><!-- End .products -->

    <div class="more-container text-center mt-2">
        <a href="#"
            class="btn btn-more"><span>Xem thêm</span></a>
    </div><!-- End .more-container -->
</div><!-- End .container -->
