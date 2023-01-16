<div class="row">
    <div class="col-lg-4">
        <div class="form-label-group">
            <label class="form-group has-float-label">
                {!! Form::select(
                    'province_id',
                    $provinces->pluck('name', 'id')->toArray(),
                    isset($address) ? $address->province->id : null,
                    ['class' => 'form-control custom-select', 'wire:model' => 'province_id', 'wire:change' => 'changeProvince'],
                ) !!}
                <span>Thành phố</span>
            </label>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="form-label-group">
            <label class="form-group has-float-label">
                {!! Form::select(
                    'district_id',
                    $districts->pluck('name', 'id')->toArray(),
                    isset($address) ? $address->district->id : null,
                    [
                        'class' => 'form-control custom-select',
                        'wire:model' => 'district_id',
                        'wire:change' => 'changeDistrict',
                    ],
                ) !!}
                <span>Quận</span>
            </label>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="form-label-group">
            <label class="form-group has-float-label">
                {!! Form::select(
                    'ward_id',
                    $wards->pluck('name', 'id')->toArray(),
                    isset($address) ? $address->ward->id : null,
                    ['class' => 'form-control custom-select', 'wire:model' => 'ward_id'],
                ) !!}
                <span>Phường</span>
            </label>
        </div>

    </div>
</div>
