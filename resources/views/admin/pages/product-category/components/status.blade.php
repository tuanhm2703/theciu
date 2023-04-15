<div class="form-check form-switch">
    <input class="form-check-input category-status" data-category-id="{{ $category->id }}" type="checkbox"
        data-submit-url="{{ route('admin.ajax.category.update', $category->id) }}"
        id="category-status-{{ $category->id }}" @if ($category->status) checked @endif>
</div>
