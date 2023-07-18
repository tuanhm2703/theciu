<div class="review">
    <div class="row no-gutters">
        <div class="col-auto">
            <div class="text-center">
                <a class="social-icon" target="_blank" style="overflow: hidden"><img
                        src="{{ $review->customer->avatar_path }}" alt=""></a>
            </div>
            <h4 class="mb-0"><a href="#">{{ $review->customer->full_name }}</a></h4>
            <div class="ratings-container">
                <div class="ratings">
                    <div class="ratings-val" style="width: {{ $review->product_score * 20 }}%;">
                    </div><!-- End .ratings-val -->
                </div><!-- End .ratings -->
            </div><!-- End .rating-container -->
        </div><!-- End .col -->
        <div class="col">
            <span class="review-date">{{ carbon($review->created_at)->format('d-m-y H:i:s') }} |
                Phân loại hàng: {{ $review->order->inventories[0]->title }}</span>
            <p>Đánh giá: <span class="font-weight-bold">{{ $review->details }}</span>
            </p>
            <div class="d-flex flex-nowrap">
                @if ($review->video)
                    <div class="p-1">
                        <a class="popup-vimeo popup-media" style="background: url({{ $review->video->thumbnail_url }})"
                            href="{{ $review->video->path_with_domain }}">
                            <div class="video-icon-label">
                                <i class="far fa-play-circle"></i>
                            </div>
                        </a>
                    </div>
                @endif
                @foreach ($review->images as $image)
                    <div class="p-1">
                        <a href="{{ $image->path_with_domain }}" class="img-popup popup-media"
                            style="background: url({{ $image->path_with_domain }})">
                            {{-- <img src="{{ $image->path_with_domain }}" alt=""> --}}
                        </a>
                    </div>
                @endforeach
            </div>
            <div class="review-action">
                <a href="#">
                    @if ($review->customer_linked && in_array(customer()?->id, $review->customer_liked))
                        <button type="button"
                            class="icon-thumbs-up btn btn-link border-0 px-0">{{ $review->likes ? $review->likes : '' }}</button>
                    @else
                        {!! Form::open([
                            'url' => route('client.auth.review.like', $review->id),
                            'method' => 'PUT',
                            'class' => 'review-react-form',
                        ]) !!}<button type="submit"
                            class="icon-thumbs-up btn btn-link border-0 px-0 text-dark">{{ $review->likes ? $review->likes : '' }}</button>
                        {!! Form::close() !!}
                    @endif
                </a>
            </div><!-- End .review-action -->
        </div><!-- End .col-auto -->
    </div><!-- End .row -->
</div><!-- End .review -->
