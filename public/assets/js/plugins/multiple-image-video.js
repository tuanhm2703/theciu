(function ($) {
    $.fn.miv = function (options) {
        var elemRef = $.extend(
            {
                type: "img",
                dragBtn: null,
                multiple: false,
                inputName: null,
                maxFile: 1,
                initSrc: [],
                required: false,
                acceptedExtensions: null,
                sortable: false,
                sortableOptions: {},
                onUploaded: (files) => {},
                onDeleted: (element) => {},
                showThumb: false,
            },
            options
        );
        elemRef.initSrc = elemRef.initSrc ? elemRef.initSrc : [];
        elemRef.multiple = elemRef.maxFile > 1;
        elemRef.multiple = false;
        const requiredMessage =
            elemRef.type == "img"
                ? "Vui lòng chọn ít nhất 1 ảnh"
                : "Vui lòng chọn ít nhất 1 video";
        const inputElement = `<div class="miv-validate-label"><input type="text" data-v-message="${requiredMessage}" ${
            elemRef.initSrc.length == 0 ? "" : 'value="true"'
        } name="${this[0].className}-label" ${
            elemRef.required ? "data-v-required" : ""
        } class="d-none"/></div>`;
        $(this).parent().prepend(inputElement);
        const labelInput = $(`input[name="${this[0].className}-label"]`);
        if (!elemRef.acceptedExtensions) {
            elemRef.acceptedExtensions =
                elemRef.type === "img" ? "image/*" : "video/*";
        }
        const className = `.${this[0].className}`;
        const initThumb = () => {
            $(this).find(".thumb-label").remove();
            $($(this).find(".apnd-img")[0])
                .append(`<div class="p-1 w-100 position-absolute fixed-bottom thumb-label" style="background-color: rgba(0,0,0,.3); font-size: 0.8em; font-weight: bold;">
            <span class="text-danger">*</span>
            <span class="text-white">Ảnh bìa</span>
            </div>`);
        };
        const printPreview = (preview, index) => {
            if (elemRef.type == "img") {
                $(className).append(
                    `<div class='apnd-img'>
                    <img src='${preview}' id='img${index}' class='img-responsive'><i class='fa fa-close delfile'></i>
                    </div>`
                );
            } else {
                $(className).append(
                    `<div class='apnd-img'>
                    <video width="100%"  id='vid${index}' controls>
                        <source src="${preview}" type="video/mp4">
                    </video><i class='fa fa-close delfile'></i>
                    </div>`
                );
            }
            if (elemRef.showThumb) initThumb();
            if (elemRef.sortable) {
                $(this).sortable({
                    update: (event, ui) => {
                        initThumb();
                        elemRef.sortableOptions.update(event, ui);
                        const prevItem = $(`input[name="${elemRef.inputName}[${$(this).attr('data-previndex')}]"]`)
                        const currentItem = $(`input[name="${elemRef.inputName}[${ui.item.index()}]"]`)
                        if(prevItem && currentItem) {
                            prevItem.attr('name', `${inputName}[${ui.item.index()}]`)
                            currentItem.attr('name', `${inputName}[${$(this).attr('data-previndex')}]"]`)
                        }
                    },
                    start: function(e, ui) {
                        $(this).attr('data-previndex', ui.item.index());
                    },
                });
            }
        };

        var i = 0;
        elemRef.initSrc.forEach((src, index) => {
            if (typeof src === "string") {
                printPreview(src, i);
            } else {
                const preview = window.URL.createObjectURL(src);
                printPreview(preview, i);
            }
            i++;
            if (i >= elemRef.maxFile) {
                $(elemRef.dragBtn).css("display", "none");
            }
        });
        $(document).off("click", elemRef.dragBtn);
        $(document).on("click", elemRef.dragBtn, function (event) {
            let inputId =
                elemRef.maxFile == 1
                    ? `${elemRef.inputName}-upload`
                    : `${elemRef.inputName}-upload${i}`;
            let inputName =
                elemRef.maxFile == 1
                    ? `${elemRef.inputName}`
                    : `${elemRef.inputName}[${i}]`;
            if (i < elemRef.maxFile) {
                if ($(`#${inputId}`).length === 0) {
                    $(elemRef.dragBtn).after(
                        `<input type='file' accept="${
                            elemRef.acceptedExtensions
                        }" id='${inputId}' ${
                            elemRef.multiple ? "multiple" : ""
                        } style='display:none;' name='${inputName}'/>`
                    );
                }
                $(`#${inputId}`).trigger("click");
                $(`#${inputId}`).on("change", (event) => {
                    const files = event.target.files;
                    for (let index = 0; index < files.length; index++) {
                        const _file = files[index];
                        const preview = window.URL.createObjectURL(_file);
                        printPreview(preview, i);
                        i++;
                        if (index < files.length - 1) {
                            inputId =
                                elemRef.maxFile == 1
                                    ? `${elemRef.inputName}-upload`
                                    : `${elemRef.inputName}-upload${i}`;
                            inputName =
                                elemRef.maxFile == 1
                                    ? `${elemRef.inputName}`
                                    : `${elemRef.inputName}[${i}]`;
                            $(elemRef.dragBtn).after(
                                `<input type='file' accept="${
                                    elemRef.acceptedExtensions
                                }" id='${inputId}' ${
                                    elemRef.multiple ? "multiple" : ""
                                } style='display:none;' name='${inputName}'/>`
                            );
                        }
                        if (i >= elemRef.maxFile) {
                            $(elemRef.dragBtn).css("display", "none");
                        }
                    }
                    elemRef.onUploaded(event);
                    labelInput.val("true");
                    labelInput.trigger("input");
                    $(`${elemRef.dragBtn} .drag-area-description`).text(
                        `(${i}/${elemRef.maxFile})`
                    );
                });
            }
        });
        $(document).on("click", `${className} .delfile`, function () {
            var elem = $(this).prev().attr("id").substr(3, 4);
            const inputId =
                elemRef.maxFile == 1
                    ? `${elemRef.inputName}-upload`
                    : `${elemRef.inputName}-upload${elem}`;
            $(this).parent().remove();
            $(document).off("change", `#${inputId}`);
            $(`#${inputId}`).remove();
            $(elemRef.dragBtn).css("display", "flex");
            i--;
            elemRef.onDeleted(this);
            labelInput.val(i == 0 ? "" : "true");
            labelInput.trigger("input");
            $(`${elemRef.dragBtn} .drag-area-description`).text(
                `(${i}/${elemRef.maxFile})`
            );
        });
        $(`${elemRef.dragBtn} .drag-area-description`).text(
            `(${i}/${elemRef.maxFile})`
        );
    };
})(jQuery);
