<div class="d-flex px-2">
    <img src="{{ optional($category->image)->path_with_domain }}"
        class="border-radius-lg shadow-sm" width="100px">

    <div class="my-auto ms-3">
        <h6 class="mb-0 text-sm">{{ $category->name }}</h6>
    </div>
</div>
