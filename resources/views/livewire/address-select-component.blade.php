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
