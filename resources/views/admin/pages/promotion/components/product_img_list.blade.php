<div class="d-flex justify-content-center">
    @foreach ($promotion->products as $product)
    <a href="{{$product->image->path_with_domain}}" class="magnifig-img product-img img-thumbnail mx-1" style="background: url({{$product->image->path_with_domain}})">
    </a>
    @endforeach
</div>
<script>
</script>

