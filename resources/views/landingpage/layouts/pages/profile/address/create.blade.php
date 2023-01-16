<div class="modal fade" id="createAddressModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalSignTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body p-0">
                <div class="form-box p-5 position-relative" style="height: 600px; overflow: scroll">
                    <h5>Thêm địa chỉ</h5>
                    <hr class="my-2">
                    {!! Form::open([
                        'url' => route('client.auth.profile.address.store'),
                        'method' => 'POST',
                        'id' => 'create-address-form'
                    ]) !!}
                    @include('landingpage.layouts.pages.profile.address.form')
                    <div class="text-right"
                        style="position: absolute; bottom: 0;
                    width: 100%;
                    right: 0;
                    padding: 1rem;">
                        <hr class="my-3">
                        <a class="ajax-modal-btn btn" id="return-address-list-btn" data-modal-size="modal-md" data-link="http://localhost:4000/auth/profile/address/view/change"><i class="fas fa-undo"></i> Quay lại</a>
                        {!! Form::submit('Thêm địa chỉ', ['class' => 'btn btn-primary']) !!}
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
