<li>
    <a href="#">Sản phẩm</a>

    <ul>
        @foreach ($product_categories as $c)
            {!! renderCategory($c) !!}
        @endforeach
    </ul>
</li>
