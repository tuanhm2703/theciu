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
    let main_product_id = @json(isset($main_product_id) ? $main_product_id : null);
    const renderPromotionSettingForm = () => {
        $('.promotion-setting-wrapper').html('')
        const renderInventories = (inventories) => {
            let output = ''
            inventories.forEach(inventory => {
                output += `
                    <div class="row mt-2">
                        <div class="offset-2 col-3 ps-4 text-sm p-0">
                            ${inventory.title}
                        </div>
                        <div class="col-1 text-center text-sm p-0">
                            ${inventory.formatted_price}
                        </div>
                        <div class="col-2 text-center justify-content-center text-sm p-0">
                            ${inventory.stock_quantity}
                        </div>
                        <div class="col-3 text-center justify-content-center text-sm p-0">
                            <input class="form-control quantity-each-order" data-product-id="${inventory.product_id}"
                                    data-inventory-id="${inventory.id}" ${inventory.product_id == main_product_id ? 'disabled' : ''} onChange="updateInventoryQuantityEachOrder(this)" value="${inventory.quantity_each_order}">
                        </div>
                        <div class="col-1 vertical-align-center justify-content-center p-0">
                            <div class="form-check form-switch">
                                <input class="form-check-input promotion-status-check ${inventory.product_id == main_product_id ? 'd-none' : ''}" data-product-id="${inventory.product_id}"
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
                                                            <div class="col-1">
                                                                <div class="form-check form-switch">
                                                                    <input class="form-check-input" name="main-product" data-product-id="${product.id}" onchange="updateMainProduct(this)" type="checkbox" ${product.id == main_product_id ? 'checked' : ''}>
                                                                </div>
                                                            </div>
                                                            <div class="col-3 d-flex">
                                                            <img src="${product.image?.path_with_domain}" class="avatar avatar-sm me-3" alt="user1">
                                                            <h6 class="mb-0 text-sm product-name" data-bs-toggle="tooltip" data-bs-placement="top" title="${product.name}"
                                                                data-container="body" data-animation="true">${product.name}</h6>
                                                        </div>
                                                        <div class="offset-6 col-1 text-start d-flex justify-content-center">
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
        const inventory = product.inventories.find(i => {
            return i.id == inventoryId
        })
        products.forEach((p) => {
            p.inventories.forEach((i) => {
                if (i.id == inventoryId) {
                    i.promotion_status = $(element).is(":checked") ? 1 : 0
                }
            })
        });
    }
    const updateMainProduct = (element) => {
        if ($(element).is(":checked")) {
            const productId = $(element).attr('data-product-id');
            products.forEach((product) => {
                if (product.id == productId) {
                    product.main_product = true;
                } else {
                    product.main_product = false;
                }
            })
            $('input[name="main-product"]').prop('checked', false)
            $(element).prop('checked', true)
            main_product_id = productId
            $(`.quantity-each-order`).attr('disabled', false)
            $('.promotion-status-check').css('display', 'block')
            $(`.quantity-each-order[data-product-id=${productId}]`).attr('disabled', true)
            $(`.promotion-status-check[data-product-id=${productId}]`).css('display', 'none')
        }
    }
    const updateInventoryQuantityEachOrder = (element) => {
        const productId = $(element).attr('data-product-id');
        const inventoryId = $(element).attr('data-inventory-id');
        const product = products.find(p => {
            return p.id == productId
        })
        const inventory = product.inventories.find(i => {
            return i.id == inventoryId
        })
        products.forEach((p) => {
            p.inventories.forEach((i) => {
                if (i.id == inventoryId) {
                    i.quantity_each_order = $(element).val()
                }
            })
        });
    }

    $(document).ready(() => {
        if (products.length > 0) renderPromotionSetting()
    })

    $('#promotion-update-btn').on('click', (e) => {
        e.preventDefault();
        if (validator.checkAll() == 0) {
            if (main_product_id == null) {
                toast.error(`{{ __('toast.action_failed') }}`, 'Vui lòng chọn sản phẩm chính cho chương trình')
                return;
            }
            if(products.length < 2) {
                toast.error(`{{ __('toast.action_failed') }}`, 'Vui lòng chọn nhiều hơn 2 sản phẩm')
                return;
            }
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
                                    promotion_price: inventory.price,
                                    promotion_status: inventory.promotion_status,
                                    quantity_each_order: inventory
                                        .quantity_each_order
                                }
                            }),
                        }
                    }),
                    type: `{{ App\Enums\PromotionType::ACCOM_PRODUCT }}`,
                    from: $('input[name=from]').val(),
                    to: $('input[name=to]').val(),
                    name: $('input[name=name]').val(),
                    main_product_id: main_product_id
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
            if ($(e.currentTarget).attr('data-product-id') == main_product_id) {
                main_product_id = null;
                $('input[name="main-product"]').prop('checked', false);
            }
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
                if ($('[name=discountType]').val() === 'percent') {
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
            if ($(this).val() === 'percent') {
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
