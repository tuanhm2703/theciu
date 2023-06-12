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
    const validator = $('.promotion-form').initValidator({
        successClass: false,
    })
    const renderPromotionSettingForm = () => {
        $('.promotion-setting-wrapper').html('')
        const renderInventories = (inventories) => {
            let output = ''
            inventories.forEach(inventory => {
                output += `
                    <div class="row mt-2">
                        <div class="offset-1 col-2 vertical-align-center ps-4 text-sm">
                            ${inventory.title}
                        </div>
                        <div class="col-1 vertical-align-center text-sm">
                            ${inventory.formatted_price}
                        </div>
                        <div class="col-3 d-flex">
                            <div class="input-group height-fit-content">
                                <span class="input-group-text text-sm" id="basic-addon2">₫<span class="after-prefix-split text-sm"></span></span>
                                <input type="number" data-product-id="${inventory.product_id}" data-inventory-id="${inventory.id}" ${inventory.promotion_status == 0 ? 'disabled' : ''}
                                    class="text-sm form-control promotion-price-input ps-1" data-v-max="${inventory.price - 1}" data-v-min="0"
                                    data-v-message="Giá không hợp lệ"
                                    value="${inventory.promotion_price ?? inventory.price}" onkeyup="fillPromotionPrice(this, 'price')" />
                            </div>
                            <span class="text-sm vertical-align-center mx-1" style="align-self: flex-start;position: relative;top: 5px;">Hoặc</span>
                            <div class="input-group height-fit-content text-sm">
                                <input type="number" class="text-sm form-control promotion-percent-input" data-product-id="${inventory.product_id}" ${inventory.promotion_status == 0 ? 'disabled' : ''}
                                    data-inventory-id="${inventory.id}"
                                    value="${Math.round(inventory.promotion_price ? 100 - (inventory.promotion_price / inventory.price * 100) : 0)}"
                                    data-v-max="100" data-v-min="0" onkeyup="fillPromotionPrice(this, 'percent')" />
                                <span class="text-sm input-group-text" id="basic-addon2"><span class="before-prefix-split"></span>%GIẢM</span>
                            </div>
                        </div>
                        <div class="col-1 vertical-align-center justify-content-center text-sm">
                            ${inventory.stock_quantity}
                        </div>
                        <div class="col-2 vertical-align-center justify-content-center text-sm">
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
                                                            <div class="form-check text-center form-check-info col-1 d-flex justify-content-center">
                                                                <input type="checkbox" value="${product.id}" name="batchUpdateProductIds[]" class="editor-active form-check-input">
                                                            </div>
                                                            <div class="col-5 d-inline">
                                                            <img src="${product.image?.path_with_domain}" class="avatar avatar-sm me-3" alt="user1">
                                                            <h6 class="mb-0 text-sm product-name" data-bs-toggle="tooltip" data-bs-placement="top" title="${product.name}"
                                                                data-container="body" data-animation="true">${product.name}</h6>
                                                        </div>
                                                        <div class="offset-5 col-1 text-start">
                                                            <div class="remove-product-btn text-sm" data-product-id="${product.id}">
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
            const percentage = 100 - (inventory.promotion_price / inventory.price * 100);
            $(element).parent().parent().find('.promotion-percent-input').val(Math.round(percentage))
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
                if (i.id == inventoryId) {
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
                    products: products.map(function(product) {
                        return {
                            id: product.id,
                            inventories: product.inventories.map(function(inventory) {
                                return {
                                    id: inventory.id,
                                    product_id: inventory.product_id,
                                    promotion_price: inventory.promotion_price,
                                    promotion_from: inventory.promotion_from,
                                    promotion_to: inventory.promotion_to,
                                    promotion_status: inventory.promotion_status,
                                }
                            })
                        }
                    }),
                    from: $('input[name=from]').val(),
                    to: $('input[name=to]').val(),
                    name: $('input[name=name]').val(),
                    type: @json($type)
                },
                success: (res) => {
                    toast.success(`{{ trans('toast.action_successful') }}`, res.data.message)
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
        $('#checkAllProduct').on('click', function(e) {
            $('[name="batchUpdateProductIds[]"]').prop('checked', $(this).is(':checked'))
            $('#numberOfCheckedProducts').text($('[name="batchUpdateProductIds[]"]:checked').length)
        })
        $('body').on('click', '[name="batchUpdateProductIds[]"]', function(e) {
            $('#numberOfCheckedProducts').text($('[name="batchUpdateProductIds[]"]:checked').length)
        })
        $('.common-info-update-btn').on('click', (e) => {
            e.preventDefault()
            $('[name="batchUpdateProductIds[]"]:checked').each(function(index, e) {
                const productId = $(e).val();
                let inputElement;
                if($('[name=discountType]').val() === 'percent') {
                    inputElement = `.promotion-percent-input[data-product-id="${productId}"]`;
                } else {
                    inputElement = `.promotion-price-input[data-product-id="${productId}"]`;
                }
                $(inputElement).each(function() {
                    $(this).val($('input[name=general-discount-percent]').val())
                    fillPromotionPrice(this, $('[name=discountType]').val())
                })
            })
        })
        $('[name=discountType]').on('change', function() {
            if($(this).val() === 'percent') {
                $('[name=general-discount-percent]').attr('max', 100);
            } else {
                $('[name=general-discount-percent]').attr('max', null);
            }
            $('[name=general-discount-percent]').trigger('input')
        })
        $('[name=form],[name=to]').on('change', function() {
            $('.datetimepicker').trigger('input')
        })
    })
</script>
