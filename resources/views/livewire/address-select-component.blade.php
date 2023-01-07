<div class="row">
    <div class="col-lg-4">
        <div class="form-label-group">
            {!! Form::select(
                'province_id',
                $provinces->pluck('name', 'id')->toArray(),
                [],
                ['class' => 'form-control', 'wire:model' => 'province_id', 'wire:change' => 'changeProvince'],
            ) !!}
            <label for="province_id">Thành phố</label>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="form-label-group">
            {!! Form::select(
                'district_id',
                $districts->pluck('name', 'id')->toArray(),
                [],
                [
                    'class' => 'form-control',
                    'placeholder' => 'Quận',
                    'wire:model' => 'district_id',
                    'wire:change' => 'changeDistrict',
                ],
            ) !!}
            <label for="district_id">Quận</label>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="form-label-group">
            {!! Form::select(
                'ward_id',
                $wards->pluck('name', 'id')->toArray(),
                [],
                ['class' => 'form-control', 'placeholder' => 'Phường', 'wire:model' => 'ward_id'],
            ) !!}
            <label for="ward_id">Phường</label>
        </div>
    </div>
</div>
