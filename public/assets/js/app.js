(function ($) {
    $.fn.loading = function (status = true, options) {
        var elemRef = $.extend({}, options);
        $(this).attr("disabled", status);
        if (status) {
            $(this).prepend(
                ` <span class="spinner-border spinner-border-sm me-3" role="status" aria-hidden="true"></span>`
            );
        } else {
            $(this).find(`.spinner-border`).remove();
        }
    };
    $.fn.initValidator = function (options) {
        const locale = $("meta[name=locale]")[0].content;
        let defaults = {
            language: `/lang/validate/${locale}.json`,
            successClass: true,
        };

        options = $.extend({}, defaults, options);
        return $(this).jbvalidator(options);
    };
    $.fn.loadingContent = function (status = true) {
        if (status == false) {
            if ($(this).find(".processing-card").length > 0) {
                $(this).find(".processing-card").remove();
            }
        } else {
            $(this).css("position", "relative");
            $(this)
                .append(` <div id="DataTables_Table_1_processing" class="dataTables_processing processing-card card absolute-center" style="display: block;">
        <div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>`);
        }
    };
})(jQuery);

(function ($) {
    $.fn.reinitFlatpickr = function (options = {}) {
        Array.from($(this)).forEach((e) => {
            const fp = flatpickr(e);
            fp.destroy();
            $(e).flatpickr(options);
        });
    };
})(jQuery);

const uploadSummernoteImage = (data, element) => {
    const editable = $(element)
        .next(".note-editor")
        .children(".note-editing-area")
        .children(".note-editable");
    editable.loading("show");
    $.ajax({
        url: "/admintheciu/ajax/image/upload",
        type: "POST",
        data: data,
        contentType: false,
        processData: false,
        success: (res) => {
            editable.loading(false);
            res.data.paths.forEach((path) => {
                $img = $("<img>").attr({
                    src: path,
                    style: "width: 100%",
                    class: "img-from-server",
                });
                $(element).summernote("insertNode", $img[0]);
                if (res.length == 1) {
                    if ($img.prev().is("img")) $img.prev().remove();
                    $img.before("<span></span>");
                    $img.after("<span></span>");
                }
                $(element).val(editable.html());
            });
        },
        error: (xhr, status, error) => {
            tata.warn(`Thao tác thất bại`, xhr.responseJSON.message);
            editable.loading(false);
        },
    });
};
