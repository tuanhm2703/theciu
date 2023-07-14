<div>
    @if ($flash_sale_products->count() > 0)
        <div class="deal bg-image pt-8 pb-8" style="background-color: #faf2e8">
            <div class="">
                <div class="row justify-content-center">
                    <div class="col-10">
                        <div class="owl-carousel owl-simple" data-toggle="owl"
                            data-owl-options='{
                            "nav": true,
                            "dots": false,
                            "margin": 30,
                            "autoplay": false,
                            "loop": true,
                            "autoplayTimeout": 3000,
                            "items": 1,
                            "responsive": {
                                "1208": {
                                    "nav": true,
                                    "items": 4
                                },
                                "992": {
                                    "nav": true,
                                    "items": 3
                                },
                                "576": {
                                    "items": 2
                                }
                            }
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
                                        <livewire:client.product-card-component :product="$product" minItem="4"/>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div><!-- End .col-lg-5 -->
                </div><!-- End .row -->
            </div><!-- End .container -->
        </div><!-- End .deal -->

    @endif
</div>
