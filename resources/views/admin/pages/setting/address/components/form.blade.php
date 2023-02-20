<div class="row mt-2">
    <div class="col-lg-6">
        <div class="form-group">
            <label for="fullname">{{ trans('labels.fullname') }}</label>
            {!! Form::text('fullname', null, [
                'placeholder' => trans('labels.fullname'),
                'class' => 'form-control',
                'required',
                'autofocus' => '',
                'wire:model' => 'address.fullname'
            ]) !!}
        </div>
    </div>
    <div class="col-lg-6">
        <div class="form-group">
            <label for="phone">{{ trans('labels.phone') }}</label>
            {!! Form::text('phone', null, [
                'placeholder' => trans('labels.phone'),
                'class' => 'form-control text-input',
                'wire:model' => 'address.phone'
            ]) !!}
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
        <div class="form-group">
            <label for="details">Địa chỉ cụ thể</label>
            {!! Form::textarea('details', null, ['class' => 'form-control']) !!}
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
{!! Form::hidden('type', App\Enums\AddressType::PICKUP, []) !!}
