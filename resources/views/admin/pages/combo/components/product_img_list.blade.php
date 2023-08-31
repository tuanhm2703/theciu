<div class="d-flex justify-content-center">
    @foreach ($combo->products as $product)
        <a href="{{ optional($product->image)->path_with_domain }}" class="magnifig-img product-img img-thumbnail mx-1"
            style="background: url({{ optional($product->image)->path_with_domain }})">
        </a>
    @endforeach
</div>
<script></script>
