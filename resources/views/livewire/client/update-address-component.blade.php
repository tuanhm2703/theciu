<div class="form-box pb-0 position-relative" style="height: 600px; overflow: scroll">
    <h5>Cập nhật địa chỉ</h5>
    <hr class="my-2">
    <div wire:loading wire:target="update" class="absolute-center">
        <div class="spinner-grow" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <div wire:loading.remove wire:target="update">
        @if ($address->id)
            {!! Form::model($address, [
                'url' => route('client.auth.profile.address.update', $address->id),
                'method' => 'PUT',
                'id' => 'update-address-form',
            ]) !!}
            @include('landingpage.layouts.pages.profile.address.form')
            <div class="text-right bg-white"
                style="position: sticky; bottom: 0;
    width: 100%;
    right: 0;
    padding: 1rem;">
                <hr class="my-3">
                <a class="ajax-modal-btn btn" id="return-address-list-btn" data-modal-size="modal-md" data-callback="initChangeModal()"
                    data-link="/auth/profile/address/view/change"><i class="fas fa-undo"></i> Quay
                    lại</a>
                <button wire:click.prevent="updateAddress" wire:loading.attr="disabled" wire:target="updateAddress" type="button"
                    class="btn btn-primary address-update-btn">
                    {{ trans('labels.update') }}
                    <span wire:loading wire:target="updateAddress" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                </button>
            </div>
            {!! Form::close() !!}
        @endif
    </div>
</div>
