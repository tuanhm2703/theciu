<div style="font-size: 10px">
    @for ($i = 0; $i < $review->product_score; $i++)
        <i class="fas fa-star" style="color: #fbda7e;"></i>
    @endfor
</div>
<p class="mb-1" style="white-space: pre-line;">{{ $review->details }}</pc>
<div class="d-flex mb-1">
    @foreach ($review->images as $image)
        <a href="#" class="magnifig-img product-img img-thumbnail me-1" width="30px"
            style="background: url({{ optional($image)->path_with_domain }})"></a>
    @endforeach
</div>
<small class="text-body-secondary">{{ $review->created_at->format('H:i d/m/Y') }}</small>
