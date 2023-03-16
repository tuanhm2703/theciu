<li class="{{ isNavActive('client.product.best_seller') ? 'active' : '' }}">
    <a href="{{ route('client.product-category.index', ['type' => App\Enums\CategoryType::BEST_SELLER]) }}">Best Seller</a>
</li>
