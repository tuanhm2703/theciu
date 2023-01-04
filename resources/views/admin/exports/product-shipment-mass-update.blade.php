<table>
    <thead>
        <tr>
            <th>Mã Sản phẩm</th>
            <th>SKU Sản phẩm</th>
            <th>Tên Sản phẩm</th>
            <th>Cân nặng sản phẩm/g</th>
            <th>Chiều dài</th>
            <th>Chiều rộng</th>
            <th>Chiều cao</th>
        </tr>
        <tr>
            <th>{{ App\Services\BatchService::SHIPMENT_BATCH_UPDATE_TYPE }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($products as $p)
            <tr>
                <td>{{ $p->id }}</td>
                <td>{{ $p->sku }}</td>
                <td>{{ $p->name }}</td>
                <td>{{ $p->weight }}</td>
                <td>{{ $p->length }}</td>
                <td>{{ $p->width }}</td>
                <td>{{ $p->height }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
