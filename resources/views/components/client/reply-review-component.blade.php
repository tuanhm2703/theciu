<div class="review border-bottom-0 mt-1">
    <div class="no-gutters d-flex">
        <div class="mr-3">
            <div class="text-center">
                <a class="social-icon" target="_blank" style="overflow: hidden; width: 3.5rem; height: 3.5rem">
                    <img src="{{ $review->replier?->avatar_path }}" alt=""></a>
            </div>
        </div><!-- End .col -->
        <div class="fr-view">
            <p><h4 class="mb-0"><a href="#">{{ $review->replier?->full_name }} <img src="{{ asset('img/verified-icon.png') }}" width="10px" alt=""></a></h4></p>
            <p>{!! $review->reply !!}</p>
        </div><!-- End .col-auto -->

    </div><!-- End .row -->
</div><!-- End .review -->
