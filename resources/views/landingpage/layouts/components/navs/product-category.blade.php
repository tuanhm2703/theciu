<li>
    <a href="{{ route('client.product.index') }}">Sản phẩm</a>

    <ul>
        @foreach ($product_categories as $c)
            {!! renderCategory($c) !!}
        @endforeach
        {!! renderCollectionCategory() !!}
    </ul>
</li>
