(() => {
    $(document).ready(() => {
        $("body").on("click", ".add-to-cart-btn", async (e) => {
            e.preventDefault();
            $(e.currentTarget).loading();
            const inventoryId = await $(e.currentTarget)
                .parents(".product")
                .find(".inventory-img-btn.active")
                .data("inventoryId");
            const response = await CartService.addToCart(inventoryId);
            reRenderCartDropdown(response.data.view);
            $(e.currentTarget).loading(false);
        });
        $("body").on("click", ".remove-cart-item-btn", async (e) => {
            e.preventDefault();
            $(e.currentTarget).loading();
            const inventoryId = $(e.currentTarget).data("inventoryId");
            const response = await CartService.removeFromCart(inventoryId);
            reRenderCartDropdown(response.data.view);
            $(e.currentTarget).loading(false);
        });
    });
})();
