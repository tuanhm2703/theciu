<div class="form-check form-switch">
    <input class="form-check-input category-status" data-category-id="{{ $category->id }}" type="checkbox"
        id="category-status-{{ $category->id }}" @if ($category->status) checked @endif>
</div>
