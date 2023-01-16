<div class="form-box p-5 position-relative" style="height: 600px; overflow: scroll">
    <h5>Cập nhật địa chỉ</h5>
    <hr class="my-2">
    @if ($address)
        {!! Form::model($address, [
            'url' => route('client.auth.profile.address.update', $address->id),
            'method' => 'PUT',
            'id' => 'update-address-form',
        ]) !!}
        @include('landingpage.layouts.pages.profile.address.form')
        <div class="text-right" style="position: absolute; bottom: 0;
    width: 100%;
    right: 0;
    padding: 1rem;">
            <hr class="my-3">
            <a class="ajax-modal-btn btn" id="return-address-list-btn" data-modal-size="modal-md"
                data-link="/auth/profile/address/view/change"><i class="fas fa-undo"></i> Quay
                lại</a>
            {!! Form::submit('Cập nhật', ['class' => 'btn btn-primary address-update-btn']) !!}
        </div>
        {!! Form::close() !!}
    @endif
</div>

