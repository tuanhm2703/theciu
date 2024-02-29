<div class="form-check form-switch justify-content-center">
    <input class="form-check-input blog-status" data-blog-id="{{ $blog->id }}" type="checkbox"
        data-submit-url="{{ route('admin.appearance.blog.update', $blog->id) }}"
        id="blog-status-{{ $blog->id }}" @if ($blog->status) checked @endif>
</div>
