<table>
    <thead>
        <tr>
            <th>Mã Sản phẩm</th>
            <th>SKU Sản phẩm</th>
            <th>Tên Sản phẩm</th>
            <th>Mô tả Sản phẩm</th>
        </tr>
        <tr>
            <th>{{ App\Services\BatchService::GENERAL_BATCH_UPDATE_TYPE }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($products as $p)
            <tr>
                <td>{{ $p->id }}</td>
                <td>{{ $p->sku }}</td>
                <td>{{ $p->name }}</td>
                <td>{{ $p->description }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
