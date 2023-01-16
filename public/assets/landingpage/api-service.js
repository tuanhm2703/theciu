const ApiCollection = {
    ADD_TO_CART_URL: "/auth/cart/add",
    REMOVE_FROM_CART_URL: "/auth/cart/remove",
};
class CartService {
    static addToCart(inventoryId) {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: ApiCollection.ADD_TO_CART_URL,
                type: "POST",
                data: {
                    inventoryId: inventoryId,
                },
                success: (res) => {
                    resolve(res)
                },
                error: (err) => {
                    if (err.status === 401) {
                        openLoginModal();
                    }
                    resolve(false)
                },
            });
        });
    }

    static removeFromCart(inventoryId) {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: ApiCollection.REMOVE_FROM_CART_URL,
                type: "delete",
                data: {
                    inventoryId: inventoryId,
                },
                success: (res) => {
                    resolve(res)
                },
                error: (err) => {
                    if (err.status === 401) {
                        openLoginModal();
                    }
                    reject(false)
                },
            });
        })
    }
}

//

class CheckoutService {
    static checkout() {

    }
}
