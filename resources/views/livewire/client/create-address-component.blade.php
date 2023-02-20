<div class="form-box position-relative pb-0" style="height: 600px; overflow: scroll">
    <h5>Thêm địa chỉ</h5>
    <hr class="my-2">
    {!! Form::open([
        'url' => route('client.auth.profile.address.store'),
        'method' => 'POST',
        'id' => 'create-address-form',
    ]) !!}
    @include('landingpage.layouts.pages.profile.address.form')
    <div class="text-right bg-white"
        style="position: sticky; bottom: 0;
    width: 100%;
    right: 0;
    padding: 1rem;">
        <hr class="my-3">
        <a class="ajax-modal-btn btn" id="return-address-list-btn" data-modal-size="modal-md" data-callback="initChangeModal()"
            data-link="{{ route('client.auth.profile.address.view.change') }}"><i class="fas fa-undo"></i> Quay lại</a>
        <button type="button" class="btn btn-primary" wire:click="store">{{ trans('labels.add_address') }}</button>
    </div>
    {!! Form::close() !!}
</div>
