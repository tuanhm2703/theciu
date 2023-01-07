<div class="row mt-2">
    <div class="col-lg-6">
        <div class="form-label-group">
            {!! Form::text('fullname', null, [
                'placeholder' => trans('labels.fullname'),
                'class' => 'form-control',
                'required',
                'autofocus' => '',
            ]) !!}
            <label for="inputEmail">{{ trans('labels.fullname') }}</label>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="form-label-group">
            {!! Form::email('email', null, [
                'placeholder' => 'Email',
                'class' => 'form-control',
                'required',
                'autofocus' => '',
            ]) !!}
            <label for="inputEmail">Email</label>
        </div>
    </div>
</div>
@livewire('address-select-component')
<div class="row">
    <div class="col-lg-12">
        <div class="form-label-group">
            {!! Form::textarea('details', null, ['class' => 'form-control']) !!}
            <label for="details">Địa chỉ cụ thể</label>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input" name="is_primary">
            <label class="custom-control-label" for="signin-remember">Đặt làm địa chỉ mặc định</label>
        </div><!-- End .custom-checkbox -->
    </div>
</div>
