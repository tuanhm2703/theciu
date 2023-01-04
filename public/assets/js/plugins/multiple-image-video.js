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
                onUploaded: (files) => {},
                onDeleted: (element) => {},
            },
            options
        );
        const requiredMessage = elemRef.type == "img" ? "Vui lòng chọn ít nhất 1 ảnh" : "Vui lòng chọn ít nhất 1 video";
        const inputElement = `<div class="miv-validate-label"><input type="text" data-v-message="${requiredMessage}" ${elemRef.initSrc.length == 0 ? '' : 'value="true"'} name="${this[0].className}-label" ${elemRef.required ? 'data-v-required' : ''} class="d-none"/></div>`
        $(this).parent().prepend(inputElement);
        const labelInput = $(`input[name="${this[0].className}-label"]`)
        if (!elemRef.acceptedExtensions) {
            elemRef.acceptedExtensions =
                elemRef.type === "img" ? "image/*" : "video/*";
        }
        const className = `.${this[0].className}`;
        const printPreview = (preview, index) => {
            if (elemRef.type == "img") {
                $(className).append(
                    `<div class='apnd-img'><img src='${preview}' id='img${index}' class='img-responsive'><i class='fa fa-close delfile'></i></div>`
                );
            } else {
                $(className).append(
                    `<div class='apnd-img'><iframe width='50' height='50' src='${preview}' id='vid${index}' frameborder='0' allowfullscreen></iframe><i class='fa fa-close delfile'></i></div>`
                );
            }
        };
        var i = 0;
        elemRef.initSrc.forEach((src) => {
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
            const inputId =
                elemRef.maxFile == 1
                    ? `${elemRef.inputName}-upload`
                    : `${elemRef.inputName}-upload${i}`;
            const inputName =
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
                        if (i >= elemRef.maxFile) {
                            $(elemRef.dragBtn).css("display", "none");
                        }
                    }
                    elemRef.onUploaded(event);
                    labelInput.val('true')
                    labelInput.trigger('input')
                    $(`${elemRef.dragBtn} .drag-area-description`).text(`(${i}/${elemRef.maxFile})`)
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
            labelInput.val(i == 0 ? '' : 'true')
            labelInput.trigger('input')
            $(`${elemRef.dragBtn} .drag-area-description`).text(`(${i}/${elemRef.maxFile})`)
        });
        $(`${elemRef.dragBtn} .drag-area-description`).text(`(${i}/${elemRef.maxFile})`)
    };
})(jQuery);
