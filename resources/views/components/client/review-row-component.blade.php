<div class="review">
    <div class="no-gutters d-flex">
        <div class="mr-5">
            <div class="text-center">
                <a class="social-icon" target="_blank" style="overflow: hidden"><img
                        src="{{ $review->customer ? $review->customer->avatar_path : getDefaultAvatar() }}" alt=""></a>
            </div>
        </div><!-- End .col -->
        <div>
            <h4 class="mb-0"><a href="#">{{ $review->customer ? $review->customer->full_name : $review->buyer_username }}</a></h4>
            <div class="ratings-container">
                <div class="ratings">
                    <div class="ratings-val" style="width: {{ $review->product_score * 20 }}%;">
                    </div><!-- End .ratings-val -->
                </div><!-- End .ratings -->
            </div><!-- End .rating-container -->
            <span class="review-date">{{ carbon($review->created_at)->format('d-m-y H:i:s') }} |
                Phân loại hàng: {{ $review->order?->inventories[0]?->title }}</span>
            <p>Đánh giá: <span style="white-space: break-spaces">{{ $review->details }}</span>
            </p>
            <div class="d-flex flex-nowrap py-2" style="overflow-x: auto">
                @if ($review->video)
                    <div class="p-1">
                        <a class="popup-vimeo popup-media border rounded-lg" style="background: url({{ $review->video->thumbnail_url }})"
                            href="{{ $review->video->path_with_domain }}">
                            <div class="video-icon-label">
                                <i class="far fa-play-circle"></i>
                            </div>
                        </a>
                    </div>
                @endif
                @foreach ($review->images as $image)
                    <div class="p-1">
                        <a href="{{ $image->path_with_domain }}" class="img-popup popup-media border rounded-lg"
                            style="background: url({{ $image->path_with_domain }})">
                            {{-- <img src="{{ $image->path_with_domain }}" alt=""> --}}
                        </a>
                    </div>
                @endforeach
            </div>
            <div class="review-action">
                <a href="#">
                    @if ($review->customer_liked && in_array(customer()?->id, $review->customer_liked))
                        <button type="button"
                            class="btn btn-link border-0 px-0"><i class="icon-thumbs-up mr-1"></i><span>{{ $review->likes ? $review->likes : '' }} Hữu ích</span></button>
                    @else
                        {!! Form::open([
                            'url' => route('client.auth.review.like', $review->id),
                            'method' => 'PUT',
                            'class' => 'review-react-form',
                        ]) !!}<button type="submit"
                            class="btn btn-link border-0 px-0 text-dark"><i class="icon-thumbs-up mr-1"></i><span>{{ $review->likes ? $review->likes : '' }} Hữu ích?</span></button>
                        {!! Form::close() !!}
                    @endif
                </a>
            </div><!-- End .review-action -->
            @if ($review->reply && $review->replier)
                <x-client.reply-review-component :review="$review"/>
            @endif
        </div><!-- End .col-auto -->
    </div><!-- End .row -->
</div><!-- End .review -->
