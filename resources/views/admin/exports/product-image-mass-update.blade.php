<table>
    <thead>
        <tr>
            <th>Mã Sản phẩm</th>
            <th>SKU Sản phẩm</th>
            <th>Tên Sản phẩm</th>
            <th>Ngành hàng</th>
            <th>Ảnh bìa</th>
            <th>Hình ảnh mẫu 1</th>
            <th>Hình ảnh mẫu 2</th>
            <th>Hình ảnh mẫu 3</th>
            <th>Hình ảnh mẫu 4</th>
            <th>Hình ảnh mẫu 5</th>
            <th>Hình ảnh mẫu 6</th>
            <th>Hình ảnh mẫu 7</th>
            <th>Hình ảnh mẫu 8</th>
            <th>Hình ảnh Bảng quy đổi kích cỡ</th>
            <th>Tên nhóm phân loại hàng 1</th>
            <th>Tên phân loại 1</th>
            <th>Hình ảnh phân loại 1</th>
            <th>Tên phân loại 2</th>
            <th>Hình ảnh phân loại 2</th>
        </tr>
        <tr>
            <th>{{ App\Services\BatchService::IMAGE_BATCH_UPDATE_TYPE }}</th>
            <th></th>
            <th></th>
            <th></th>
            <th>image</th>
            <th>image</th>
            <th>image</th>
            <th>image</th>
            <th>image</th>
            <th>image</th>
            <th>image</th>
            <th>image</th>
            <th>image</th>
            <th>image_size_rule</th>
            <th></th>
            <th></th>
            <th>first_attribute_image</th>
            <th></th>
            <th>second_attribute_image </th>
        </tr>
        <tr>
            <th>Không thể chỉnh sửa</th>
            <th>Không thể chỉnh sửa</th>
            <th>Không thể chỉnh sửa</th>
            <th>Không thể chỉnh sửa</th>
            <th>Bắt buộc</th>
            <th>Tùy chọn</th>
            <th>Tùy chọn</th>
            <th>Tùy chọn</th>
            <th>Tùy chọn</th>
            <th>Tùy chọn</th>
            <th>Tùy chọn</th>
            <th>Tùy chọn</th>
            <th>Tùy chọn</th>
            <th>Tùy chọn</th>
            <th>Không thể chỉnh sửa</th>
            <th>Không thể chỉnh sửa</th>
            <th>Tùy chọn</th>
            <th>Không thể chỉnh sửa</th>
            <th>Tùy chọn</th>
        </tr>
        <tr>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th>
                Vui lòng chèn URL hình ảnh. Lưu ý: mỗi sản phẩm đăng bán phải có ít nhất 1 hình ảnh được đăng thành
                công.
            </th>
            <th>Vui lòng chèn URL hình ảnh</th>
            <th>Vui lòng chèn URL hình ảnh</th>
            <th>Vui lòng chèn URL hình ảnh</th>
            <th>Vui lòng chèn URL hình ảnh</th>
            <th>Vui lòng chèn URL hình ảnh</th>
            <th>Vui lòng chèn URL hình ảnh</th>
            <th>Vui lòng chèn URL hình ảnh</th>
            <th>Vui lòng chèn URL hình ảnh</th>
            <th>
                Bảng quy đổi kích cỡ chỉ khả dụng cho các sản phẩm trong danh mục cụ thể. Đối với những sản phẩm không
                khả dụng, trường này sẽ có màu xám.
            </th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($products as $p)
            <tr>
                <td>{{ $p->id }}</td>
                <td>{{ $p->sku }}</td>
                <td>{{ $p->name }}</td>
                <td>{{ $p->category->name }}</td>
                @foreach ($p->images as $i)
                    <td>{{ $i->path_with_domain }}</td>
                @endforeach
                @for ($i = 0; $i < 9 - $p->images->count(); $i++)
                    <td></td>
                @endfor
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        @endforeach
    </tbody>
</table>
