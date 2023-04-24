<script>
    let productIds =
        @if (isset($productIds))
            @json($productIds)
        @else
            []
        @endif ;
    let products =
        @if (isset($products))
            @json($products)
        @else
            []
        @endif ;
    const validator = $('.promotion-form').initValidator()
    const renderPromotionSettingForm = () => {
        $('.promotion-setting-wrapper').html('')
        const renderInventories = (inventories) => {
            let output = ''
            inventories.forEach(inventory => {
                output += `
                    <div class="row mt-2">
                        <div class="col-2 vertical-align-center ps-4">
                            ${inventory.title}
                        </div>
                        <div class="col-1 vertical-align-center">
                            ${inventory.formatted_price}
                        </div>
                        <div class="col-4 d-flex">
                            <div class="input-group height-fit-content">
                                <span class="input-group-text" id="basic-addon2">₫<span class="after-prefix-split"></span></span>
                                <input type="number" data-product-id="${inventory.product_id}" data-inventory-id="${inventory.id}" ${inventory.promotion_status == 0 ? 'disabled' : ''}
                                    class="form-control promotion-price-input ps-1" data-v-max="${inventory.price - 1}" data-v-min="0"
                                    data-v-message="Giá không hợp lệ"
                                    value="${inventory.promotion_price ?? inventory.price}" onkeyup="fillPromotionPrice(this, 'price')" />
                            </div>
                            <span class="vertical-align-center mx-1" style="align-self: flex-start;position: relative;top: 5px;">Hoặc</span>
                            <div class="input-group height-fit-content">
                                <input type="number" class="form-control promotion-percent-input" data-product-id="${inventory.product_id}" ${inventory.promotion_status == 0 ? 'disabled' : ''}
                                    data-inventory-id="${inventory.id}"
                                    value="${inventory.promotion_price ? 100 - (inventory.promotion_price / inventory.price * 100) : 0}"
                                    data-v-max="100" data-v-min="0" onkeyup="fillPromotionPrice(this, 'percent')" />
                                <span class="input-group-text" id="basic-addon2"><span class="before-prefix-split"></span>%GIẢM</span>
                            </div>
                        </div>
                        <div class="col-1 vertical-align-center justify-content-center">
                            ${inventory.stock_quantity}
                        </div>
                        <div class="col-2 vertical-align-center justify-content-center">
                            ${inventory.stock_quantity}
                        </div>
                        <div class="col-1 vertical-align-center justify-content-center">
                            <div class="form-check form-switch">
                                <input class="form-check-input" data-product-id="${inventory.product_id}"
                                    data-inventory-id="${inventory.id}" onChange="updateInventoryPromotionStatus(this)" type="checkbox"
                                    ${inventory.promotion_status ? 'checked' : '' }>
                            </div>
                        </div>
                    </div>
                    `
            })
            return output
        }
        products.forEach(product => {
            $('.promotion-setting-wrapper').append(`<div class="product-setting-info mt-3">
                                                        <div class="row product-header-info">
                                                            <div class="col-6 d-inline">
                                                            <img src="${product.image?.path_with_domain}" class="avatar avatar-sm me-3" alt="user1">
                                                            <h6 class="mb-0 text-sm product-name" data-bs-toggle="tooltip" data-bs-placement="top" title="${product.name}"
                                                                data-container="body" data-animation="true">${product.name}</h6>
                                                        </div>
                                                        <div class="offset-5 col-1 text-start">
                                                            <div class="remove-product-btn" data-product-id="${product.id}">
                                                                <i class="far fa-trash-alt"></i>
                                                                </div>
                                                        </div>
                                                            </div>
                                                        ${renderInventories(product.inventories)}
                                                    </div>`)
        });
    }
    const renderPromotionSetting = () => {
        $.ajax({
            url: `{{ route('admin.ajax.promotion.product.with_inventories') }}`,
            type: 'GET',
            data: {
                ids: productIds
            },
            success: (res) => {
                const ids = products.map(product => {
                    return product.id
                })
                res.data.forEach(product => {
                    if (ids.indexOf(product.id) < 0) {
                        products.push(product)
                    }
                });
                renderPromotionSettingForm()
            }
        })
    }
    const fillPromotionPrice = (element, type) => {
        const {
            productId,
            inventoryId
        } = $(element).data();
        const product = products.find(p => {
            return p.id == productId
        })
        const inventory = product.inventories.find(i => {
            return i.id == inventoryId
        })
        if (type === 'price') {
            inventory.promotion_price = $(element).val()
            $(element).parent().parent().find('.promotion-percent-input').val(100 - (inventory.promotion_price /
                inventory.price * 100))
        } else {
            inventory.promotion_price = inventory.price - (inventory.price / 100 * $(element).val());
            $(element).parent().parent().find('.promotion-price-input').val(inventory.promotion_price)
        }
    }

    const updateInventoryPromotionStatus = (element) => {
        const {
            productId,
            inventoryId
        } = $(element).data();
        const product = products.find(p => {
            return p.id = productId
        })
        const inventory = product.inventories.find(i => {
            return i.id = inventoryId
        })
        products.forEach((p) => {
            p.inventories.forEach((i) => {
                if(i.id == inventoryId) {
                    i.promotion_status = $(element).is(":checked") ? 1 : 0
                }
            })
        });

        $(`.promotion-price-input[data-inventory-id=${inventoryId}]`).attr('disabled', !$(element).is(":checked"))
        $(`.promotion-percent-input[data-inventory-id=${inventoryId}]`).attr('disabled', !$(element).is(
            ":checked"))

    }

    $(document).ready(() => {
        if (products.length > 0) renderPromotionSetting()
    })

    $('#promotion-update-btn').on('click', (e) => {
        if (validator.checkAll() == 0) {
            $(e.target).loading()
            $.ajax({
                url: $('.promotion-form').attr('action'),
                type: @json(isset($promotion) ? 'PUT' : 'POST'),
                data: {
                    products: products,
                    from: $('input[name=from]').val(),
                    to: $('input[name=to]').val(),
                    name: $('input[name=name]').val(),
                    type: @json($type)
                },
                success: (res) => {
                    tata.success(`{{ trans('toast.action_successful') }}`, res.data.message)
                    setTimeout(() => {
                        window.location.href = `{{ route('admin.promotion.index') }}`
                    }, 1000);
                },
                error: (err) => {
                    $(e.target).loading(false)
                }
            })
        }
    })
    $(document).ready(() => {
        $('body').on('click', '.remove-product-btn', (e) => {
            const productIndex = productIds.indexOf($(e.currentTarget).data('productId'))
            productIds.splice(productIndex, 1)
            products.splice(productIndex, 1)
            $(e.currentTarget).parents('.product-setting-info').remove()
        })
    })
</script>
