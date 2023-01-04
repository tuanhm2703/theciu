<div class="heading heading-center mb-3">
    <h2 class="title">Trending</h2><!-- End .title -->

    <ul class="nav nav-pills justify-content-center" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="trending-all-link" data-toggle="tab" href="#trending-all-tab" role="tab"
                aria-controls="trending-all-tab" aria-selected="true">Tất cả</a>
        </li>
        @foreach ($trending_categories as $category)
            <li class="nav-item">
                <a class="nav-link" id="category-{{ $category->id }}-link" data-toggle="tab"
                    href="#category-{{ $category->id }}-tab" role="tab"
                    aria-controls="category-{{ $category->id }}-tab" aria-selected="false">{{ $category->name }}</a>
            </li>
        @endforeach
    </ul>
</div><!-- End .heading -->
<div class="tab-content tab-content-carousel trending-carousel">
    <div class="tab-pane p-0 fade show active" id="trending-all-tab" role="tabpanel"
        aria-labelledby="trending-all-link">
        <div class="owl-carousel owl-simple carousel-equal-height carousel-with-shadow" data-toggle="owl"
            data-owl-options='{
                "nav": false,
                "dots": true,
                "margin": 20,
                "loop": false,
                "responsive": {
                    "0": {
                        "items":1
                    },
                    "480": {
                        "items":1
                    },
                    "768": {
                        "items":1
                    },
                    "992": {
                        "items":3
                    },
                    "1200": {
                        "items":4,
                        "nav": true,
                        "dots": false
                    }
                }
            }'>
            @foreach ($trending_categories as $category)
                @foreach ($category->products as $product)
                    @component('components.client.product-card', compact('product'))
                    @endcomponent
                @endforeach
            @endforeach

        </div><!-- End .owl-carousel -->
    </div><!-- .End .tab-pane -->
    @foreach ($trending_categories as $category)
        <div class="tab-pane p-0 fade" id="category-{{ $category->id }}-tab" role="tabpanel"
            aria-labelledby="category-{{ $category->id }}-link">
            <div class="owl-carousel owl-simple carousel-equal-height carousel-with-shadow" data-toggle="owl"
                data-owl-options='{
                "nav": false,
                "dots": true,
                "margin": 20,
                "loop": false,
                "responsive": {
                    "0": {
                        "items":0
                    },
                    "480": {
                        "items":2
                    },
                    "768": {
                        "items":3
                    },
                    "992": {
                        "items":4
                    },
                    "1200": {
                        "items":4,
                        "nav": true,
                        "dots": false
                    }
                }
            }'>
                @foreach ($category->products as $product)
                    @component('components.client.product-card', compact('product'))
                @endcomponent
                @endforeach
            </div><!-- End .owl-carousel -->
        </div><!-- .End .tab-pane -->
    @endforeach
</div><!-- End .tab-content -->
