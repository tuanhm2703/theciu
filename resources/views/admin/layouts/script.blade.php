<script>
    FilePond.registerPlugin(FilePondPluginImagePreview);
    $(".ajax-modal-btn").hide(); // hide the ajax functional button untill the page load completely
    $.extend(true, $.fn.dataTable.defaults, {
        language: DataTable.languages[`{{ App::getLocale() }}`]
    });

    const initSummernote = (element) => {
        const correctSummernote = () => {
            $("button[data-toggle='dropdown']").each(function(index) {
                        $(this).removeAttr("data-toggle").attr("data-bs-toggle", "dropdown");
                    });
            var styleEle = $("style#fixed");
            if (styleEle.length == 0)
                $("<style id=\"fixed\">.note-editor .dropdown-toggle::after { all: unset; } .note-editor .note-dropdown-menu { box-sizing: content-box; } .note-editor .note-modal-footer { box-sizing: content-box; }</style>").prependTo("body");
            else
                styleEle.remove();
        }
        element.summernote({
            callbacks: {
                onImageUpload: function(files, editor, welEditable) {
                    const formData = new FormData()
                    for (let index = 0; index < files.length; index++) {
                        const element = files[index];
                        formData.append('images[]', element)
                    }
                    var data = uploadSummernoteImage(formData, this)
                },
                onChange: function(contents, $editable) {
                    $($editable).parents('.note-editor').prev().trigger('input')
                },
                onInit: function() {
                    correctSummernote()
                }
            },
            lang: `{{ App::getLocale() }}-{{ getLocaleWithCountryCode()[App::getLocale()] }}`
        });

    }
    const initAppPlugins = () => {
        $.ajaxSetup({
            cache: false,
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            }
        });
        $('.select2').select2({
            placeholder: "Vui lòng chọn"
        });
        $('.datetimepicker').flatpickr({
            enableTime: true,
            minDate: `{{ now()->format('Y-m-d') }}`,
        })
        $('.datepicker').flatpickr({
            minDate: `{{ now()->format('Y-m-d') }}`,
        })
        initSummernote($('body .summernote'))
        if ($("[data-bs-toggle=tooltip]").length) {
            $("[data-bs-toggle=tooltip]").tooltip({
                html: true
            });
        }
        Array.from($('.select2-ajax')).forEach(e => {
            const selected = $(e).data().selected ? $(e).data().selected : []
            $(e).select2({
                placeholder: 'Vui lòng chọn',
                tags: true,
                closeOnSelect: false,
                ajax: {
                    url: $(e).data().select2Url,
                    dataType: 'json',
                    processResults: function(data) {
                        return {
                            results: data.data
                        };
                    }
                }
            })
        })
        $('.magnifig-img').magnificPopup({
            type: "image",
        });
    }
    const showConfirm = (title = 'Xác nhận thao tác', content) => {
        return new Promise((resolve, reject) => {
            $.confirm({
                title: `<h6 class="text-danger"><i class="fas fa-exclamation" aria-hidden="true"></i> ${title}</h6>`,
                content: content,
                type: 'red',
                typeAnimated: true,
                buttons: {
                    tryAgain: {
                        text: 'Xác nhận',
                        btnClass: 'btn-red',
                        action: function() {
                            resolve(true)
                        }
                    },
                    close: function() {
                        resolve(false)
                    }
                }
            });
        })
    }
    $(document).ready(() => {
        initAppPlugins()
        $(document).on('click', '.nav-tabs a', (e) => {
            e.preventDefault()
            $(e.target).tab('show')
        })
        $('.ajax-modal-btn').removeAttr('href').css('cursor', 'pointer').show();
        $('#myDynamicModal').on('hidden.bs.modal', (e) => {
            if ($(e.target).attr('id') == 'myDynamicModal') {
                $('#myDynamicModal .modal-dialog').removeClass()
                $('#myDynamicModal>div').addClass('modal-dialog modal-dialog-centered')
            }
        })

        $('body').on('click', '.ajax-modal-btn', function(e) {
            e.preventDefault();
            const btn = $(this)
            const modalSize = $(this).data().modalSize ?? 'modal-lg'
            const modalId = $(this).data().modalId ?? 'myDynamicModal'
            $(this).loading()
            var url = $(this).data('link');
            const callback = $(this).data('callback')
            var ajaxElement = this
            if (url.indexOf('#') == 0) {
                $(url).modal('open');
            } else {
                $.get(url, function(data) {
                        $(`#${modalId} .modal-body`).html(data);
                        $(`#${modalId} .modal-dialog`).addClass(modalSize)
                        $(`#${modalId}`).modal('show');
                        $('.modal-body input:text:visible:first').focus();
                        //Initialize application plugins after ajax load the content
                        if (typeof initAppPlugins == 'function' && $(ajaxElement).attr(
                                'data-init-app') == null) {
                            $(ajaxElement).attr('data-init-app') == null
                            initAppPlugins();
                        }
                        if (callback) eval(callback)

                    })
                    .done(function() {
                        $(btn).loading(false)
                    })
                    .fail(function(response) {
                        $(btn).loading(false)
                        if (401 === response.status) {
                            window.location = "{{ route('admin.login') }}";
                        }
                    });
            }
        });

        $('body').on('click', '.ajax-confirm', async (e) => {
            e.preventDefault()
            const content = `{{ trans('labels.confirm_execute_action') }}`
            const result = await showConfirm(undefined, content)
            if (result) {
                const form = $(e.target).parents('form')
                form.submit()
            }
        })
        $(document).on('click', '.mass-checkbox-btn', (e) => {
            $(e.target).parents('table').children('tbody').find('.child-checkbox').prop('checked', $(e
                .target).is(':checked'))
        })
    })
</script>
