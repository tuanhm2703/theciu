<li class="{{ isNavActive('client.product.best_seller') ? 'active' : '' }}">
    <a href="{{ route('client.category.index', ['type' => App\Enums\CategoryType::BEST_SELLER]) }}">Best Seller</a>
</li>
