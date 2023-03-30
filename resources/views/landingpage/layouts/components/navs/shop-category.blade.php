<li class="{{ isNavActive('client.product.new_arrival') ? 'active' : '' }}">
    <a href="{{ route('client.category.index', ['type' => App\Enums\CategoryType::NEW_ARRIVAL]) }}">New</a>
</li>
