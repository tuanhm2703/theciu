<script>
    let attributes = []
    let inventories = []
    let listCategories = []
    let deleteImages = []
    let productImgSrc =
        @if (isset($listImgSources))
            @json($listImgSources)
        @else
            []
        @endif ;
    let productCategoryIds =
        @if (isset($product))
            @json($product->category_ids)
        @else
            []
        @endif ;
    let productVideoSrc = `{{ isset($product) ? optional($product->video)->path_with_domain : '' }}`
    let productSizeRuleSrc = `{{ isset($product) ? optional($product->size_rule_image)->path_with_domain : '' }}`
    var productFormValidator
    $(document).ready(() => {
        initProductDetailsInfoSelector()
        $('.img-gallery').miv({
            dragBtn: '.img-drag',
            inputName: 'images',
            maxFile: 9,
            multiple: true,
            required: true,
            initSrc: productImgSrc,
            onDeleted: (element) => {
                element = $(element).parent().find('img')[0]
                deleteImages.push($(element).attr('src'))
            }
        });
        $('.video-gallery').miv({
            type: 'vid',
            dragBtn: '.video-drag',
            inputName: 'video',
            required: false,
            initSrc: productVideoSrc !== '' ? [productVideoSrc] : [],
            onDeleted: (element) => {
                element = $(element).parent().find('iframe')[0]
                deleteImages.push($(element).attr('src'))
            }
        })
        $('.size-rule-gallery').miv({
            dragBtn: '.size-rule-drag',
            inputName: 'size-rule-img',
            onDeleted: (element) => {
                element = $(element).parent().find('img')[0]
                deleteImages.push($(element).attr('src'))
            },
            initSrc: productSizeRuleSrc !== '' ? [productSizeRuleSrc] : [],
        })
        $('#save-category-btn').on('click', (e) => {
            finishChooseCategories()
            $('input[name=category]').trigger('input')
        })
        $('.fix-not-btn').on('click', (e) => {
            $([document.documentElement, document.body]).animate({
                scrollTop: $(".invalid-feedback").first().offset().top
            }, 0);
        })
        $(window).on("scroll", function() {
            $('.product-step').each((i, el) => {
                if (withinviewport(el)) {
                    const elId = $(el)[0].id
                    $('.side-nav .item').removeClass('active')
                    $(`.side-nav .item[data-step-name="${elId}"]`).addClass('active')
                }
            })
        });
        productFormValidator = $('.product-form').initValidator({
            validationCallback: () => {
                const numberOfError = $('.is-invalid').length
                if (numberOfError > 0) {
                    $(`.product-number-of-invalidate`).text(`Có ${numberOfError} lỗi`)
                    $('.product-submit-error-tip').removeClass('d-none')
                } else {
                    $('.product-submit-error-tip').addClass('d-none')
                }
            }
        })
        $('.step-sidebar-wrapper .item a').on('click', (e) => {
            e.preventDefault()
            const href = e.target.getAttribute('href').replace('#', '')
            const el = document.getElementById(href)
            el.scrollIntoView({
                behavior: "smooth",
                block: "center"
            });
        })
        getListCategories()
    })

    const getListCategories = () => {
        $.ajax({
            url: '{{ route('admin.ajax.category.all') }}?type=product',
            type: 'GET',
            success: (res) => {
                listCategories = res.data.data
                renderChildCategories(listCategories, 1)
                let categories = listCategories
                productCategoryIds.forEach((categoryId, level) => {
                    renderChildCategories(categories, level + 1)
                    const element = $(
                            `.category-selector .nav-link[data-category-id="${categoryId}"]`)
                        .trigger('click')
                    const category = categories.find((c) => c.id == categoryId)
                    categories = category.categories ?? []
                });
                finishChooseCategories()
                renderSelectedCategories()
            },
            error: (err) => {
                console.log(err);
            }
        })
    }

    const renderChildCategories = (categories, level) => {
        $('#save-category-btn').attr('disabled', true)
        $(`.category-level-${level} .nav`).html('')
        if (level == 2) {
            $(`.category-level-2 .nav`).html('')
            $(`.category-level-3 .nav`).html('')
        }
        categories.forEach((element, index) => {
            $(`.category-level-${level} .nav`).append(`
                                <li class="nav-item ${index > 0 ? 'mt-3' : ''}">
                                        <div class="nav-link mb-0 px-0 py-1 d-flex align-items-center justify-content-between" data-category-name="${element.name}" data-category-id="${element.id}"  data-bs-toggle="tab" role="tab" aria-controls="preview"
                                        ${`onClick='renderChildCategories(${element.categories?.length > 0 ? JSON.stringify(element.categories) : '[]'}, ${level + 1})'`}
                                        aria-selected="true">
                                        ${element.name}
                                        <i class="fas fa-angle-right float-end"></i>
                                    </div>
                                </li>
                        `)
        });
        $('#save-category-btn').attr('disabled', categories.length != 0)
        renderSelectedCategories()
    }

    const renderSelectedCategories = () => {
        const categories = $('.category-selector .nav-item .active')
        const categoryNames = Array.from(categories).map((element) => {
            return $(element).data().categoryName
        })
        const categoryIds = Array.from(categories).map((element) => {
            return $(element).data().categoryId
        })
        const categoryId = categoryIds.length == 0 ? $('input[name="category_id"]').val() : categoryIds.pop()
        let check = !$('#save-category-btn')[0].disabled
        // listCategories.forEach(c => {
        //     check = checkCategorySelected(c, categoryId)
        //     if (check) return
        // });
        $('input[name="category_id"]').val(check ? categoryId : '')
        $('.categories-selected').html(categoryNames.join(' > '))
    }
    const checkCategorySelected = (category, id) => {
        if (category.categories) {
            for (let index = 0; index < category.categories.length; index++) {
                const c = category.categories[index];
                if (checkCategorySelected(c, id)) return true
            }
        } else {
            return category.id === id
        }
        return false;
    }

    const finishChooseCategories = () => {
        const categories = $('.category-selector .nav-item .active')
        const categoryNames = Array.from(categories).map((element) => {
            return $(element).data().categoryName
        })
        $('input[name="category"]').val(categoryNames.join(' > '))
        $('#exampleModal').modal('hide')
    }

    const initAttributeAjaxSelect = (selectElement) => {
        $(selectElement).select2({
            data: [{
                id: $(selectElement).val(),
                text: $(selectElement).text()
            }],
            tags: true,
            ajax: {
                url: '{{ route('admin.ajax.attribute.search') }}',
                dataType: 'json',
                processResults: function(data) {
                    return {
                        results: data.data
                    };
                }
            }
        })
    }

    const initProductDetailsInfoSelector = () => {
        const elements = $('.product-detail-info-selector')
        Array.from(elements).forEach(selector => {
            const fieldName = $(selector).data().fieldName
            $(selector).select2({
                tags: true,
                placeholder: 'Vui lòng chọn',
                ajax: {
                    url: `{{ route('admin.ajax.product.detail_value') }}?field=${fieldName}`,
                    dataType: 'json',
                    processResults: function(data) {
                        return {
                            results: data.data
                        };
                    }
                }
            })
        })
    }
    const renderAttributeForm = (isNew = true) => {
        const maxNumberOfAttributes = 2;
        if (isNew) attributes.push({
            values: [{
                value: null,
                inventories: []
            }],
            name: null,
            id: null,
        })

        $('.attribute-group').html('')
        attributes.forEach((element, index) => {
            $('.attribute-group').append(`
                    <div class="card attribute-info-form mt-3 position-relative" data-attribute-index="${index + 1}">
                        <div class="card-body p-3">
                            <i onClick="deleteAttributeForm(this)" style="cursor: pointer" class="fas fa-times position-absolute top-10 end-1"></i>
                            <div class="row">
                                <div class="col-md-3">
                                    {!! Form::label('', 'Phân loại nhóm ${index + 1}', ['class' => 'custom-control-label']) !!}
                                </div>
                                <div class="col-md-3" style="padding-right: 55px;">
                                    <select ${element.name ? `value="${element.name}"` : ''} class="form-control attribute-ajax-select2" placeholder="Ví dụ: Màu sắc, v.v" onChange="fillAttributeName(this, event)">
                                        ${element.name ? `<option value="${element.id}">${element.name}</option>` : ''}
                                    </select>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-3">
                                    <label class="custom-control-label">Phân loại hàng</label>
                                </div>
                                <div class="col-md-9">
                                    <div class="row attribute-value-wrapper">
                                        ${renderAttributeValue(element)}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `)
            const selectElement = $('.attribute-ajax-select2')[$('.attribute-ajax-select2').length - 1]
            initAttributeAjaxSelect(selectElement)
        })
        const numberOfAttributes = $('.attribute-info-form').length
        $('#add-attribute-btn').css('display', `${numberOfAttributes >= maxNumberOfAttributes ? 'none' : 'inline'}`)
        renderAttributeTable()
    }

    const renderAttributeValue = (attribute) => {
        let output = ''
        if (attribute.values.length == 0) {
            return output += `<div class="col-md-4">
                                    <input class="form-control required attribute-value-input" placeholder="Ví dụ: Trắng, đỏ, v.v" onkeyup="fillAttributeValue(this, event)"/>
                                </div>`;
        }
        attribute.values.forEach((value, index) => {
            output += `<div class="col-md-4 ${index > 2 ? 'mt-3' : ''}">
                        <div class="d-flex align-items-center">
                            <input required class="form-control attribute-value-input" ${value.value ? `value="${value.value}"` : ''} accept-charset="utf-8"  placeholder="Ví dụ: Trắng, đỏ, v.v" onkeyup="fillAttributeValue(this, event)"/>
                                    <i class="fas fa-arrows-alt p-1" style="color: lightgrey; font-size: 15px"></i>
                                    <i class="delete-attribute-value-btn far fa-trash-alt p-1" style="color: lightgrey; font-size: 15px" onClick="deleteAttributeValue(this)"></i>
                                    </div>
                                </div>`
        })
        return output;
    }

    const fillAttributeValue = (element, event) => {
        const attributeIndex = $(element).parents('.card.attribute-info-form').data().attributeIndex - 1
        let valueIndex = $(element).index('.attribute-value-input')
        attributes.forEach((attribute, index) => {
            if (index < attributeIndex) valueIndex -= attribute.values.length
        })
        if (attributes[attributeIndex].values[valueIndex]) {
            attributes[attributeIndex].values[valueIndex].value = event.target.value
        } else {
            attributes[attributeIndex].values[valueIndex] = {
                value: event.target.value,
                inventories: []
            }
        }
        if (attributes[attributeIndex].values.length == valueIndex + 1) {
            $(element).parents('.attribute-value-wrapper').append(`<div class="col-md-4 ${valueIndex >= 2 ? 'mt-3' : ''}">
                                    <div class="d-flex align-items-center"><input class="form-control required attribute-value-input" placeholder="Ví dụ: Trắng, đỏ, v.v" onkeyup="fillAttributeValue(this, event)"/>
                                        <i class="fas fa-arrows-alt p-1" style="color: lightgrey; font-size: 15px"></i>
                                        <i class="delete-attribute-value-btn far fa-trash-alt p-1" style="color: lightgrey; font-size: 15px" onClick="deleteAttributeValue(this)"></i>
                                    </div>
                                </div>`)
            attributes[attributeIndex].values.push({
                value: null,
                inventories: []
            })
        }
        renderAttributeTable()
    }

    const fillAttributeName = (element, event) => {
        const attributeIndex = $(element).parents('.card.attribute-info-form').data().attributeIndex - 1
        attributes[attributeIndex].name = $(element).find(':selected').text()
        attributes[attributeIndex].id = $(element).find(':selected').val()
        renderAttributeTable()
    }

    const fillInventoryInfo = (element, field) => {
        let index = $(element).index(`.${field}-input`)
        attributes[0].values.forEach(value => {
            if (value.inventories.length - 1 >= index) {
                value.inventories[index][field] = $(element).val()
            } else {
                index = index - value.inventories.length
            }
        });
    }

    const deleteAttributeForm = (element) => {
        const index = $(element).parents('.card.attribute-info-form').data().attributeIndex - 1;
        attributes.splice(index, 1)
        renderAttributeForm(false)
    }
    const renderAttributeTableHeader = () => {
        let output = `<th class="text-uppercase text-center text-dark text-xxs font-weight-bolder opacity-7 ps-2">
                                    <span class="text-danger">*</span> Giá
                                </th>
                                <th class="text-center text-uppercase text-dark text-xxs font-weight-bolder opacity-7">
                                    <span class="text-danger">*</span> Kho hàng
                                </th>
                                <th class="text-center text-uppercase text-dark text-xxs font-weight-bolder opacity-7">
                                    SKU Phân loại
                                    </th>`
        let attributeHtml = ''
        attributes.forEach((attribute, index) => {
            attributeHtml +=
                `<th class="text-uppercase text-dark text-center text-xxs font-weight-bolder opacity-7">${attribute.name ? attribute.name : `Nhóm phân loại ${index + 1}`}</th>`
        });
        output = attributeHtml + output
        output = `<tr>${output}</tr>`
        $('#attribute-table thead').html(output)
    }
    const renderAttributeColumn = (value, valueIndex) => {
        let output = ''
        value.inventories.forEach((inventory, index) => {
            let columns = []
            inventory.attributes.forEach((attribute, i) => {
                if (i == 0) {
                    if (index > 0) columns[i] = ''
                    else columns[i] = `<td rowspan="${value.inventories.length}">
                                                                    <p style="font-size: 0.825rem" class="text-center">${value.value ? value.value : ''}</p>
                                                                    <div class="attribute-${valueIndex}-img"></div>
                                                                    <div class="btn-border-dash drag-area img-${valueIndex}-drag" style="width: 80px; height: 80px; margin: auto">
                                                                        <div class="icon text-center">
                                                                            <svg viewBox="0 0 23 21" xmlns="http://www.w3.org/2000/svg">
                                                                                <path d="M18.5 0A1.5 1.5 0 0 1 20 1.5V12c-.49-.07-1.01-.07-1.5 0V1.5H2v12.65l3.395-3.408a.75.75 0 0 1 .958-.087l.104.087L7.89 12.18l3.687-5.21a.75.75 0 0 1 .96-.086l.103.087 3.391 3.405c.81.813.433 2.28-.398 3.07A5.235 5.235 0 0 0 14.053 18H2a1.5 1.5 0 0 1-1.5-1.5v-15A1.5 1.5 0 0 1 2 0h16.5z">
                                                                                </path>
                                                                                <path
                                                                                    d="M6.5 4.5a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3zM18.5 14.25a.75.75 0 0 1 1.5 0v2.25h2.25a.75.75 0 0 1 0 1.5H20v2.25a.75.75 0 0 1-1.5 0V18h-2.25a.75.75 0 0 1 0-1.5h2.25v-2.25z">
                                                                                </path>
                                                                            </svg>
                                                                        </div>
                                                                        <span class="support text-center"></span>
                                                                    </div>
                                                                </td>`
                } else {
                    columns[i] =
                        `<td><p class="text-center text-md" style="font-size: 0.875rem">${attribute.value ? attribute.value : ''}</p></td>`
                }
            });
            columns.push(`<td>
                                            <div class="input-group">
                                                    <span class="input-group-text border-end">₫</span>
                                                    <input type="number" required class="form-control price-input" ${inventory.price ? `value="${inventory.price}"` : ''}  onkeyup="fillInventoryInfo(this, 'price')" placeholder="Nhập vào">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group">
                                                    <input type="number" required class="form-control stock_quantity-input" value="${inventory.stock_quantity}" onkeyup="fillInventoryInfo(this, 'stock_quantity')">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group">
                                                    <input type="text" class="form-control sku-input" ${inventory.sku ? `value="${inventory.sku}"` : ''}  placeholder="Nhập vào" onkeyup="fillInventoryInfo(this, 'sku')">
                                                </div>
                                            </td>`)
            output = `<tr>${columns.join('')}</tr>`
            $('#attribute-table tbody').append(output)
        })
        $(`.attribute-${valueIndex}-img`).miv({
            dragBtn: `.img-${valueIndex}-drag`,
            inputName: `attribute-image-${valueIndex}`,
            maxFile: 1,
            required: true,
            initSrc: value.image ? [value.image] : [],
            onDeleted: (element) => {
                element = $(element).parent().find('img')[0]
                deleteImages.push($(element).attr('src'))
            }
        });

    }

    const deleteAttributeValue = (element) => {
        let index = $(element).index('.delete-attribute-value-btn')
        if (attributes[0].values.length - 1 < index) {
            index = attributes[0].values.length - index - 1;
            attributes[1].values.splice(index, 1)
        } else {
            attributes[0].values.splice(index, 1)
        }
        renderAttributeForm(false)
    }

    const renderAttributeTable = () => {
        $('#attribute-table tbody').html('')
        attributes[0].values.forEach((value, i) => {
            const inventories = []
            if (value.value || i != attributes[0].values.length - 1 || i == 0) {
                if (attributes[1]) {
                    attributes[1].values.forEach((val, j) => {
                        if ((val.value || j != attributes[1].values.length - 1) || j == 0) {
                            inventories.push({
                                price: null,
                                sku: null,
                                stock_quantity: 0,
                                id: null,
                                attributes: [{
                                    id: attributes[0].id,
                                    name: attributes[0].name,
                                    value: value.value
                                }, {
                                    id: attributes[1].id,
                                    name: attributes[1].name,
                                    value: val.value
                                }]
                            })
                        }
                    });
                } else {
                    inventories.push({
                        price: null,
                        sku: null,
                        stock_quantity: 0,
                        id: null,
                        attributes: [{
                            id: attributes[0].id,
                            name: attributes[0].name,
                            value: value.value
                        }]
                    })
                }
                inventories.forEach((inventory, index) => {
                    if (value.inventories[index]) {
                        value.inventories[index].attributes = inventory.attributes
                    } else {
                        value.inventories[index] = inventory
                    }
                });
                if (value.inventories.length > inventories.length) {
                    value.inventories.splice(inventories.length - 1, value.inventories.length - inventories
                        .length)
                }
            }

        });
        renderAttributeTableHeader()
        attributes[0].values.forEach((value, index) => {
            if (value.value || index != attributes[0].values.length - 1 || index == 0) {
                renderAttributeColumn(value, index)
            }
        })
    }

    const applyCommonDataForInventory = (event) => {
        event.preventDefault()
        const elements = $('.common-input')
        if (attributes[0]) {
            attributes[0].values.forEach(value => {
                value.inventories.forEach(inventory => {
                    Array.from(elements).forEach(element => {
                        const fieldName = $(element).data().field
                        const val = $(element).val()
                        if (val) inventory[fieldName] = val
                    });
                });
            });
        }
        renderAttributeTable()
    }


    $(document).on('click', '#add-attribute-btn', (e) => {
        e.preventDefault()
        renderAttributeForm()

    })
    $('.product-form').on('submit', (e) => {
        e.preventDefault()
        let formData = new FormData($('.product-form')[0])
        formData.append('attributes', JSON.stringify(attributes))
        formData.append('deleteImages', JSON.stringify(deleteImages))
        const checkResult = productFormValidator.checkAll()
        if (checkResult == 0) {
            $('.submit-btn').loading()
            $.ajax({
                url: e.target.action,
                type: e.target.method,
                data: formData,
                dataType: 'json',
                contentType: false,
                processData: false,
                success: (res) => {
                    tata.success('{{ trans('toast.action_successful') }}', res.data.message)
                    setTimeout(() => {
                        window.location.href = `{{ route('admin.product.index') }}`
                    }, 600);
                },
                error: (err) => {
                    $('.submit-btn').loading(false)
                    tata.error('{{ trans('toast.action_failed') }}', err.responseJSON.message);
                }
            })
        }
    })
    // .ajaxForm({
    //     beforeSerialize: function($form, options) {
    //         console.log($form);
    //     },
    //     beforeSend: (arr, $form, options) => {
    //         let data = $('.product-form').serializeArray()
    //         data['attributes'] = attributes
    //         $form.data = JSON.stringify(data)
    //     },
    //     success: (res) => {
    //         // console.log(res);
    //     },
    //     error: (err) => {
    //         // console.log(err);
    //     }
    // })
    // jQuery.fn.swap = function(b) {
    //     // method from: http://blog.pengoworks.com/index.cfm/2008/9/24/A-quick-and-dirty-swap-method-for-jQuery
    //     b = jQuery(b)[0];
    //     var a = this[0];
    //     var t = a.parentNode.insertBefore(document.createTextNode(''), a);
    //     b.parentNode.insertBefore(a, b);
    //     t.parentNode.insertBefore(b, t);
    //     t.parentNode.removeChild(t);
    //     return this;
    // };


    // $(".input-group").draggable({
    //     revert: true,
    //     helper: "clone"
    // });

    // $(".input-group").droppable({
    //     accept: ".input-group",
    //     activeClass: "ui-state-hover",
    //     hoverClass: "ui-state-active",
    //     drop: function(event, ui) {

    //         var draggable = ui.draggable,
    //             droppable = $(this),
    //             dragPos = draggable.position(),
    //             dropPos = droppable.position();

    //         draggable.css({
    //             left: dropPos.left + 'px',
    //             top: dropPos.top + 'px'
    //         });

    //         droppable.css({
    //             left: dragPos.left + 'px',
    //             top: dragPos.top + 'px'
    //         });
    //         draggable.swap(droppable);
    //     }
    // });
    // const handleBeforeUnload = (e) => {
    //     e.preventDefault();
    //     const message =
    //         "Bạn có muốn rời đi? Tất cả dữ liệu thay đổi sẽ mất.";
    //     e.returnValue = message;
    //     return message;
    // };
    // window.addEventListener("beforeunload", handleBeforeUnload);
</script>
