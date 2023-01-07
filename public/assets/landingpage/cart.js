(() => {
    $(document).ready(() => {
        $("body").on("click", ".add-to-cart-btn", async (e) => {
            e.preventDefault();
            $(e.currentTarget).loading();
            const inventoryId = await $(e.currentTarget)
                .parents(".product")
                .find(".inventory-img-btn.active")
                .data("inventoryId");
            Livewire.emit("cart:itemAdded", inventoryId);
            $(e.currentTarget).loading(false);
            setTimeout(() => {
                $(".cart-dropdown").addClass("show");
            }, 500)
        });
    });
})();
