<x-admin.card header="Thông tin cơ bản" cardClass="product-step" id="general-info-step">
    <div class="row">
        <div class="col-md-2">
            {!! Form::label('images[]', 'Hình ảnh sản phẩm', ['class' => 'custom-control-label label-required']) !!}
        </div>
        <div class="col-md-10">
            <div class="img-gallery"></div>
            <x-admin.bordered-add-btn text="Thêm hình ảnh" class="img-drag">
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
    <div class="row mt-3">
        <div class="col-md-2">
            {!! Form::label('video', 'Video sản phẩm', ['class' => 'custom-control-label']) !!}
        </div>
        <div class="img-input-wrapper col-md-10">
            <div class="d-flex">
                <div class="video-gallery"></div>
                <x-admin.bordered-add-btn text="Thêm video" class="video-drag">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16">
                        <path
                            d="M13 2a1 1 0 0 1 1 1v7.035a3.538 3.538 0 0 0-1 0V3H2v10h8.035a3.538 3.538 0 0 0 0 1H2a1 1 0 0 1-1-1V3a1 1 0 0 1 1-1h11z">
                        </path>
                        <path
                            d="M6 5.667c0-.481.549-.755.933-.467l3.111 2.333c.312.234.312.7 0 .934L6.934 10.8A.583.583 0 0 1 6 10.333V5.667zm7 5.833a.5.5 0 0 1 1 0V13h1.5a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0V14h-1.5a.5.5 0 0 1 0-1H13v-1.5z">
                        </path>
                    </svg>
                </x-admin.bordered-add-btn>
                <ul style="font-size: 12px; line-height: 1.2rem;">
                    <li>Kích thước: Tối đa 30Mb, độ phân giải không vượt quá 1280x1280px</li>
                    <li>Độ dài: 10s-60s</li>
                    <li>Định dạng: MP4 (không hỗ trợ vp9)</li>
                    <li>Lưu ý: sản phẩm có thể hiển thị trong khi video đang được xử lý. Video sẽ tự động
                        hiển thị sau khi đã xử lý thành công.</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-2">
            {!! Form::label('name', 'Tên sản phẩm', ['class' => 'custom-control-label label-required']) !!}
        </div>
        <div class="col-md-10">
            {!! Form::text('name', null, [
                'class' => 'form-control',
                'placeholder' => 'Nhập vào',
                'required',
                'data-v-min-length' => 10,
            ]) !!}
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-md-2">
            {!! Form::label('category', 'Chọn ngành hàng', ['class' => 'custom-control-label label-required']) !!}
        </div>
        <div class="col-md-10">
            {!! Form::text('category', null, [
                'class' => 'form-control',
                'placeholder' => 'Chọn ngành hàng',
                'data-bs-toggle' => 'modal',
                'data-bs-target' => '#exampleModal',
                'readonly',
                'required',
                'data-v-required',
            ]) !!}
            {!! Form::text('category_id', null, ['class' => 'd-none']) !!}
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-2">
            {!! Form::label('short_description', 'Mô tả ngắn', ['class' => 'custom-control-label label-required']) !!}
        </div>
        <div class="col-md-10">
            {!! Form::textarea('short_description', null, [
                'class' => 'form-control',
                'minlength' => '50',
                'maxlength' => '255',
                'placeholder' => 'Nhập vào',
                'rows' => 5,
                'required',
            ]) !!}
        </div>
    </div>
</x-admin.card>
