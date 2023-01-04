<table>
    <thead>
        <tr>
            <th>Mã Sản phẩm</th>
            <th>Tên Sản phẩm</th>
            <th>Mã phân loại</th>
            <th>Tên phân loại</th>
            <th>SKU sản phẩm</th>
            <th>SKU</th>
            <th>Giá</th>
            <th>Số lượng</th>
        </tr>
        <tr>
            <th>{{ App\Services\BatchService::SALE_BATCH_UPDATE_TYPE }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($products as $p)
            @foreach ($p->inventories as $i)
                <tr>
                    <td>{{ $p->id }}</td>
                    <td>{{ $p->name }}</td>
                    <td>{{ $i->id }}</td>
                    <td>{{ $i->title }}</td>
                    <td>{{ $p->sku }}</td>
                    <td>{{ $i->sku }}</td>
                    <td>{{ $i->price }}</td>
                    <td>{{ $i->stock_quantity }}</td>
                </tr>
            @endforeach
        @endforeach
    </tbody>
</table>
