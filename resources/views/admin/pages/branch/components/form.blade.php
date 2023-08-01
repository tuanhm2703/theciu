<div class="card mb-4">
    <div class="card-header">
        <h6>Basic information</h6>
    </div>
    <div class="card-body pt-0 pb-2">
        <div class="row">
            <div class="col-12 col-md-6">
                <div class="form-group">
                    {!! Form::label('name', __('labels.name'), ['class' => 'custom-label']) !!}
                    {!! Form::text('name', null, ['class' => 'form-control']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('name', 'Giờ mở cửa', ['class' => 'custom-label']) !!}
                    <div class="d-flex">
                        {!! Form::datetime('open_time', null, [
                            'class' => 'form-control hourPicker me-3',
                            'required',
                            'placeholder' => 'Giờ mở cửa',
                        ]) !!}
                        {!! Form::datetime('close_time', null, [
                            'class' => 'form-control hourPicker',
                            'required',
                            'placeholder' => 'Giờ đóng cửa',
                        ]) !!}
                    </div>
                </div>
                <div class="form-check form-switch">
                    {!! Form::checkbox('status', true, true, ['class' => 'form-check-input']) !!}
                    {!! Form::label('status', __('labels.status'), ['class' => 'form-check-label']) !!}
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="form-group">
                    {!! Form::label('image', trans('labels.image'), ['class' => 'custom-label-control']) !!}
                    {!! Form::file('image', ['class' => 'form-control', 'required']) !!}
                </div>
            </div>
        </div>
    </div>
</div>
<div class="card mb-3">
    <div class="card-header">
        <h6>
            Location address
        </h6>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-12 col-md-6 position-relative">
                <input id="pac-input" class="form-control w-75" type="text" placeholder="Search Box" />
                <div id="google-map-wrapper">

                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="form-group">
                    {!! Form::label('google_latitude', 'Vĩ độ', ['class' => 'custom-label']) !!}
                    {!! Form::text('google_latitude', null, ['class' => 'form-control']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('google_longitude', 'Kinh độ', ['class' => 'custom-label']) !!}
                    {!! Form::text('google_longitude', null, ['class' => 'form-control']) !!}
                </div>
            </div>
        </div>
        <div class="row mt-5">
            @if (isset($branch))
            <livewire:address-select-component :address="$branch->address"/>
            @else
                <livewire:address-select-component/>
            @endif
        </div>
        <div class="row">
            <div class="form-group">
                {!! Form::label('address[details]', __('labels.address_detail'), ['class' => 'custom-label']) !!}
                {!! Form::text('address[details]', null, ['class' => 'form-control']) !!}
            </div>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-header">
        <h6>Contact Details</h6>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-12 col-md-6">
                {!! Form::label('phone', __('labels.phone'), ['class' => 'custom-label']) !!}
                {!! Form::text('phone', null, ['class' => 'form-control']) !!}
            </div>
            <div class="col-12 col-md-6">
                {!! Form::label('email', __('labels.email_address'), ['class' => 'custom-label']) !!}
                {!! Form::text('email', null, ['class' => 'form-control']) !!}
            </div>
        </div>
    </div>
</div>
