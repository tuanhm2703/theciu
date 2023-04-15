<div class="form-check form-switch justify-content-center">
    <input class="form-check-input banner-status" data-banner-id="{{ $banner->id }}" type="checkbox"
        data-submit-url="{{ route('admin.appearance.banner.update', $banner->id) }}"
        id="banner-status-{{ $banner->id }}" @if ($banner->status) checked @endif>
</div>
