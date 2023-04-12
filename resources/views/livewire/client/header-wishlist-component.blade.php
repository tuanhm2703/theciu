<a href="#" wire:click.prevent="redirectToWishlistPage" class="wishlist-link" wire:init="loadContent">
    <i class="icon-heart-o"></i>
    @if ($readyToLoad)
        <span class="wishlist-count">{{ $number_of_wishlists }}</span>
    @endif
    <span class="wishlist-txt"></span>
</a>
