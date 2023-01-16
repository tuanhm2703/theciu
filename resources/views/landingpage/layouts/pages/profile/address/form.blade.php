<div class="row mt-2">
    <div class="col-lg-6">
        <div class="form-group input-group">
            <span class="has-float-label w-100">
                {!! Form::text('fullname', null, [
                    'placeholder' => trans('labels.fullname'),
                    'class' => 'form-control',
                    'required',
                    'autofocus' => '',
                ]) !!}
                <label for="inputEmail">{{ trans('labels.fullname') }}</label>
            </span>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="form-group input-group">
            <span class="has-float-label w-100">
                {!! Form::text('phone', null, [
                    'placeholder' => trans('labels.phone'),
                    'class' => 'form-control text-input',
                    'required',
                    'autofocus' => '',
                ]) !!}
                <label for="phone">{{ trans('labels.phone') }}</label>
            </span>
        </div>
    </div>
</div>

@if (isset($address))
    <livewire:address-select-component :address="$address"></livewire:address-select-component>
@else
    <livewire:address-select-component></livewire:address-select-component>
@endif
<div class="row">
    <div class="col-lg-12">
        <div class="form-group input-group">
            <span class="has-float-label w-100">
                {!! Form::textarea('details', null, ['class' => 'form-control']) !!}
                <label for="details">Địa chỉ cụ thể</label>
            </span>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="custom-control custom-checkbox">
            <input name="featured" @checked(isset($address) && $address->featured == 1) type="checkbox" class="custom-control-input"
                id="featured">
            <label class="custom-control-label" for="featured">Đặt làm địa chỉ mặc định</label>
        </div>
    </div>
</div>
{!! Form::hidden('type', App\Enums\AddressType::SHIPPING, []) !!}
