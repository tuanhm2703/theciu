<div class="d-flex justify-content-center">
    @foreach ($product->images as $image)
        <a href="{{ $image->path_with_domain }}" class="magnifig-img product-img img-thumbnail mx-1"
            style="background: url({{ $image->path_with_domain }})">
        </a>
    @endforeach
</div>
