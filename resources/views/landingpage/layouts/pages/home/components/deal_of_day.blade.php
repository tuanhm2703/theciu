@if ($flash_sale_products->count() > 0)
    <div class="deal bg-image pt-8 pb-8"
        style="background-image: url(/img/promotion-background.png);">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-sm-12 col-md-8 col-lg-6">
                    <div class="owl-carousel owl-simple" data-toggle="owl"
                        data-owl-options='{
                            "nav": false,
                            "dots": false,
                            "margin": 30,
                            "autoplay": true,
                            "loop": false,
                            "autoplayTimeout": 3000,
                            "items": 1
                        }'>
                        @foreach ($flash_sale_products as $product)
                            <div>
                                <div class="deal-content text-center">
                                    <h4>Số lượng có hạn. </h4>
                                    <h2>{{ $product->flash_sale->name }}</h2>
                                    <div class="deal-countdown" data-until="+{{ $product->flash_sale->time_left }}s">
                                    </div><!-- End .deal-countdown -->
                                </div><!-- End .deal-content -->
                                <div class="row deal-products justify-content-center">
                                    <livewire:client.product-card-component :product="$product"></livewire:client.product-card-component>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div><!-- End .col-lg-5 -->
            </div><!-- End .row -->
        </div><!-- End .container -->
    </div><!-- End .deal -->

@endif
