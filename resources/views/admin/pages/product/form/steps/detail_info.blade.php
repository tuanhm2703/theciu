<x-admin.card header="Thông tin chi tiết" cardClass="mt-3 product-step" id="detail-info-step">
    <div class="row">
        <div class="col-xl-6 col-12">
            <div class="row mt-3">
                <div class="col-lg-3 col-12">
                    {!! Form::label('material', 'Chất liệu', ['class' => 'custom-control-label label-required']) !!}
                </div>
                <div class="col-lg-9 col-12">
                    {!! Form::select(
                        'material',
                        isset($product) ? [$product->material => $product->material] : [],
                        isset($product) ? [$product->material => $product->material] : [],
                        [
                            'class' => 'form-control product-detail-info-selector',
                            'data-field-name' => 'material',
                            'data-v-min-select' => 1,
                            'required',
                            'data-v-required',
                        ],
                    ) !!}
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-12">
            <div class="row mt-3">
                <div class="col-lg-3 col-12">
                    {!! Form::label('type', 'Kiểu', ['class' => 'custom-control-label label-required']) !!}
                </div>
                <div class="col-lg-9 col-12">
                    {!! Form::select(
                        'type',
                        isset($product) ? [$product->type => $product->type] : [],
                        isset($product) ? [$product->type => $product->type] : [],
                        [
                            'class' => 'form-control product-detail-info-selector',
                            'data-field-name' => 'type',
                            'required',
                        ],
                    ) !!}
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-12">
            <div class="row mt-3">
                <div class="col-lg-3 col-12">
                    {!! Form::label('style', 'Phong cách', ['class' => 'custom-control-label label-required']) !!}
                </div>
                <div class="col-lg-9 col-12">
                    {!! Form::select(
                        'style',
                        isset($product) ? [$product->style => $product->style] : [],
                        isset($product) ? [$product->style => $product->style] : [],
                        [
                            'class' => 'form-control product-detail-info-selector',
                            'data-field-name' => 'style',
                            'required',
                        ],
                    ) !!}
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-12">
            <div class="row mt-3">
                <div class="col-lg-3 col-12">
                    {!! Form::label('model', 'Mẫu', ['class' => 'custom-control-label label-required']) !!}
                </div>
                <div class="col-lg-9 col-12">
                    {!! Form::select(
                        'model',
                        isset($product) ? [$product->model => $product->model] : [],
                        isset($product) ? [$product->model => $product->model] : [],
                        [
                            'class' => 'form-control product-detail-info-selector',
                            'data-field-name' => 'model',
                            'required',
                        ],
                    ) !!}
                </div>
            </div>
        </div>
    </div>
</x-admin.card>
