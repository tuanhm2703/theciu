<div>
    <div>
        @if (Session::has('message'))
            <div class="alert alert-success mb-3" role="alert">
                {{ Session::get('message') }}
            </div>
        @endif
        {!! Form::model($user, []) !!}
        <div class="row">
            <div class="col-sm-6">
                <label>{{ trans('labels.first_name') }} *</label>
                {!! Form::text('first_name', null, ['class' => 'form-control', 'required', 'wire:model' => 'user.first_name']) !!}
                @error('user.first_name')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div><!-- End .col-sm-6 -->

            <div class="col-sm-6">
                <label>{{ trans('labels.last_name') }} *</label>
                {!! Form::text('last_name', null, ['class' => 'form-control', 'required', 'wire:model' => 'user.last_name']) !!}
            </div><!-- End .col-sm-6 -->
        </div><!-- End .row -->

        <div class="row">
            <div class="col-12 col-lg-6">
                <label>{{ trans('labels.email_address') }} *</label>
                {!! Form::text('email', null, ['class' => 'form-control', 'required', 'wire:model' => 'user.email']) !!}
                @error('user.email')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-12 col-lg-6">
                <label>{{ trans('labels.phone') }} *</label>
                <div class="position-relative">
                    <span class="form-control">{{ $user->phone }}</span>
                    <a class="d-flex align-items-center" href="{{ route('client.auth.profile.phone') }}"
                        style="position: absolute;
                               top: 50%;
                               right: 0;
                               transform: translate(-10%, -50%);}">
                        {{ trans('labels.change_phone') }}
                    </a>
                </div>
                @error('user.phone')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>
        </div>
        @if (empty(customer()->provider))
            <div class="row">
                <div class="col-12 col-lg-6">
                    {!! Form::label('password', trans('labels.password'), []) !!}
                    <div class="position-relative">
                        <input type="password" class="form-control" readonly name="password" disabled value="********">
                        <a class="d-flex align-items-center" href="{{ route('client.auth.profile.password') }}"
                            style="position: absolute;
                               top: 50%;
                               right: 0;
                               transform: translate(-10%, -50%);}">
                            {{ trans('labels.change_password') }}
                        </a>
                    </div>
                </div>
            </div>
        @endif
        <div class="row">
            <div class="col-12 col-lg-6">
                <div class="d-flex">
                    {!! Form::label('reward_point', 'Điểm thưởng còn lại:', []) !!}
                    <div class="position-relative ml-3">
                        <strong>
                            <p>{{ $user->reward_point }}</p>
                        </strong>
                    </div>
                </div>
            </div>
        </div>
        <button type="submit" wire:click.prevent="update" class="btn btn-outline-primary-2" style="width: 200px">
            <span wire:loading.remove wire:target="update">{{ trans('labels.update') }} <i
                    class="icon-long-arrow-right"></i></span>
            <span wire:loading wire:target="update">Saving..</span>
        </button>
        {!! Form::close() !!}
        <button data-toggle="modal" data-target="#removeAccountConfirmModal" type="button" class="btn btn-primary mt-1"
            style="width: 200px">
            <span>Xoá tài khoản <i class="fas fa-trash"></i></span>
        </button>
    </div>
    <div class="modal fade" id="removeAccountConfirmModal" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalSignTitle" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header p-0">
                    <div class="d-flex align-items-center justify-content-center bg-light p-4">
                        <img src="{{ getLogoUrl() }}" alt="{{ getAppName() }} - Logo" width="20%">
                    </div>
                </div>
                <div class="modal-body p-4 p-md-5 pt-0">
                    <h6 class="text-uppercase text-center font-weight-bold py-5 mb-0 ">Xác nhận xoá tài khoản</h6>
                    <div class="m-auto mb-3">
                        <p>Bạn có chắc chắn muốn xoá tài khoản của mình không? Tất cả dữ liệu liên quan sẽ bị mất và không thể khôi phục.<br>
                        Vui lòng xác nhận mật khẩu để xoá tài khoản:</p>
                        <input wire:model="confirmDeleteAccountPassword" type="password" class="form-control" name="confirmDeleteAccountPassword">
                        @if($errorDeleteAccount)
                            <span class="text-danger">{{ $errorDeleteAccount }}</span>
                        @endif
                    </div>
                    <div class="d-flex justify-content-center">
                        <button wire:click.prevent="deleteAccount" wire:target='deleteAccount' wire:loading.attr="disabled" class="btn btn-primary mr-3">
                            <span wire:loading.remove='deleteAccount' wire:target='deleteAccount'>Xác nhận</span>
                            <span wire:loading wire:target='deleteAccount'>Đang xoá...</span>
                        </button>
                        <button data-dismiss="modal" class="btn btn-outline-primary-2">Huỷ bỏ</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
