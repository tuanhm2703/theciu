<div class="row mt-2">
    <div class="col-lg-6">
        <div class="form-group input-group">
            <span class="has-float-label w-100">
                {!! Form::text('fullname', null, [
                    'placeholder' => trans('labels.fullname'),
                    'class' => 'form-control',
                    'required',
                    'autofocus' => '',
                    'wire:model' => 'address.fullname',
                ]) !!}
                <label for="inputEmail">{{ trans('labels.fullname') }}</label>
            </span>
            @error('address.fullname')
                <span class="text-danger mt-1">{{ $message }}</span>
            @enderror
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
                    'wire:model' => 'address.phone',
                ]) !!}
                <label for="phone">{{ trans('labels.phone') }}</label>
            </span>
            @error('address.phone')
                <span class="text-danger mt-1">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-4">
        <div class="form-label-group">
            <label class="form-group has-float-label">
                {!! Form::select('province_id', $provinces->pluck('name', 'id')->toArray(), null, [
                    'class' => 'form-control custom-select',
                    'wire:model' => 'address.province_id',
                    'wire:change' => 'changeProvince',
                ]) !!}
                <span>Thành phố</span>
            </label>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="form-label-group">
            <label class="form-group has-float-label">
                {!! Form::select('district_id', $districts->pluck('name', 'id')->toArray(), null, [
                    'class' => 'form-control custom-select',
                    'wire:model' => 'address.district_id',
                    'wire:change' => 'changeDistrict',
                ]) !!}
                <span>Quận</span>
            </label>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="form-label-group">
            <label class="form-group has-float-label">
                {!! Form::select('ward_id', $wards->pluck('name', 'id')->toArray(), null, [
                    'class' => 'form-control custom-select',
                    'wire:model' => 'address.ward_id',
                ]) !!}
                <span>Phường</span>
            </label>
        </div>

    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="form-group input-group">
            <span class="has-float-label w-100">
                {!! Form::textarea('details', null, ['class' => 'form-control', 'wire:model' => 'address.details']) !!}
                <label for="details">Địa chỉ cụ thể</label>
            </span>
            @error('address.details')
                    <span class="text-danger mt-1">{{ $message }}</span>
                @enderror
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="custom-control custom-checkbox">
            <input name="featured" wire:model="address.featured" @checked(isset($address) && $address->featured == 1) type="checkbox"
                class="custom-control-input" id="featured">
            <label class="custom-control-label" for="featured">Đặt làm địa chỉ mặc định</label>
        </div>
    </div>
</div>
{!! Form::hidden('type', null, ['wire:model' => 'address.type']) !!}
