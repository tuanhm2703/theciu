<div class="d-flex px-2 py-1">
    <a href="{{ optional($branch->image)->path_with_domain }}" class="magnifig-img product-img img-thumbnail mx-1"
        style="background: url({{ optional($branch->image)->path_with_domain }})"></a>
<div class="d-flex flex-column justify-content-center">
    <h6 class="mb-0 text-sm">{{ $branch->name }}</h6>
</div>
</div>
