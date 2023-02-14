<div class="related-posts">
    <h3 class="title">{{ trans('labels.related_blogs') }}</h3><!-- End .title -->

    <div class="owl-carousel owl-simple" data-toggle="owl"
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
                    "items":2
                },
                "768": {
                    "items":3
                }
            }
        }'>
        @foreach ($blogs as $blog)
            @component('components.client.blog-card', compact('blog'))
            @endcomponent
        @endforeach
    </div><!-- End .owl-carousel -->
</div><!-- End .related-posts -->
