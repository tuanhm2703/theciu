<x-admin.card header="Thông tin bán hàng" cardClass="mt-3 product-step" id="sale-info-step">
    <div class="row">
        <div class="col-lg-2">
            {!! Form::label('attribute', 'Phân loại hàng', ['class' => 'custom-control-label']) !!}
        </div>
        <div class="col-lg-10">
            <button id="add-attribute-btn" class="text-bold text-danger btn-border-dash"><i class="fas fa-plus"></i>
                Thêm nhóm
                phân loại</button>
            <div class="attribute-group"></div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-lg-2">
            {!! Form::label('', 'Danh sách phân loại nhóm hàng', ['class' => 'custom-control-label']) !!}
        </div>
        <div class="col-lg-7">
            <div class="d-flex input-group">
                <span class="input-group-text" id="basic-addon1"></span>
                <input type="text" class="form-control p-1 validate-disabled common-input" placeholder="Giá"
                    name="common-price" data-field="price" novalidate>
                <input type="text" class="form-control p-1 validate-disabled common-input" placeholder="Kho hàng"
                    data-field="stock_quantity" name="common-quantity" novalidate
                    style="border-left: 1px solid #d2d6da !important">
                <input type="text" class="form-control p-1 validate-disabled common-input"
                    placeholder="SKU Phân loại" data-field="sku" name="common-sku" novalidate
                    style="border-left: 1px solid #d2d6da !important">
            </div>
        </div>
        <div class="col-lg-3 mt-3 mt-md-0 text-end">
            <button class="btn btn-primary" onClick="applyCommonDataForInventory(event)">Áp dụng cho tất cả các
                loại</button>
        </div>
        <div class="mt-3">
            <div class="row">
                <div class="col-lg-2"></div>
                <div class="col-lg-10">
                    <table class="table table-bordered align-items-center mb-0" id="attribute-table">
                        <thead style="background-color: #f5f5f5">
                            <tr>
                                <th class="text-uppercase text-dark text-xxs font-weight-bolder opacity-7">
                                    Nhóm phân loại 1</th>
                                <th class="text-uppercase text-dark text-xxs font-weight-bolder opacity-7 ps-2">
                                    <span class="text-danger">*</span> Giá
                                </th>
                                <th class="text-center text-uppercase text-dark text-xxs font-weight-bolder opacity-7">
                                    <span class="text-danger">*</span> Kho hàng
                                </th>
                                <th class="text-center text-uppercase text-dark text-xxs font-weight-bolder opacity-7">
                                    SKU Phân loại</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-lg-2">
            {!! Form::label('size_rule_img', 'Hình ảnh Bảng quy đổi kích cỡ', ['class' => 'custom-control-label']) !!}
        </div>
        <div class="col-lg-10">
            <div class="size-rule-gallery"></div>
            <x-admin.bordered-add-btn class="size-rule-drag" text="Thêm hình ảnh">
                <svg viewBox="0 0 23 21" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M18.5 0A1.5 1.5 0 0 1 20 1.5V12c-.49-.07-1.01-.07-1.5 0V1.5H2v12.65l3.395-3.408a.75.75 0 0 1 .958-.087l.104.087L7.89 12.18l3.687-5.21a.75.75 0 0 1 .96-.086l.103.087 3.391 3.405c.81.813.433 2.28-.398 3.07A5.235 5.235 0 0 0 14.053 18H2a1.5 1.5 0 0 1-1.5-1.5v-15A1.5 1.5 0 0 1 2 0h16.5z">
                    </path>
                    <path
                        d="M6.5 4.5a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3zM18.5 14.25a.75.75 0 0 1 1.5 0v2.25h2.25a.75.75 0 0 1 0 1.5H20v2.25a.75.75 0 0 1-1.5 0V18h-2.25a.75.75 0 0 1 0-1.5h2.25v-2.25z">
                    </path>
                </svg>
            </x-admin.bordered-add-btn>
        </div>
    </div>
</x-admin.card>
