<a class="btn btn-link text-dark px-3 mb-0 ajax-modal-btn" href="javascript:;" data-init-app="false"
    data-link="{{ route('admin.category.edit', $category->id) }}"><i class="fas fa-pencil-alt text-dark me-2"
        aria-hidden="true"></i>Chỉnh sửa</a>

<a class="btn btn-link text-dark px-3 mb-0 ajax-modal-btn" href="javascript:;" data-init-app="false"
    data-link="{{ route('admin.ajax.category.view.add_product', ['category' => $category->id]) }}"><i
        class="ni ni-fat-add text-dark me-2" aria-hidden="true"></i>Thêm sản phẩm</a>
