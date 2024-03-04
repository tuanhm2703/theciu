<script>
    FilePond.registerPlugin(FilePondPluginImagePreview);
    $(".ajax-modal-btn").hide(); // hide the ajax functional button untill the page load completely
    $.extend(true, $.fn.dataTable.defaults, {
        language: DataTable.languages[`{{ App::getLocale() }}`]
    });

    const initSummernote = async (element) => {
        $('.summernote').each((i, e) => {
            ClassicEditor
                .create(e, {
                    simpleUpload: {
                                uploadUrl: `{{ route('admin.ajax.image.upload') }}`,
                        },
                        fontFamily: {
                                options: [
                                        'Poppins, sans-serif', // Added Poppins
                                        'Arial, Helvetica, sans-serif',
                                        'Courier New, Courier, monospace',
                                        'Georgia, serif',
                                        'Lucida Sans Unicode, Lucida Grande, sans-serif',
                                        'Tahoma, Geneva, sans-serif',
                                        'Times New Roman, Times, serif',
                                        'Verdana, Geneva, sans-serif'
                                ]
                        },
                })
        })
    }
    const initSimpleSummernote = (element) => {
        $('.summernote-simple').addClass('invisible')
        $('.summernote-simple').each((i, e) => {
            ClassicEditor.create(e, {
                toolbar: {
                    items: [
                        'alignment',
                        'heading',
                        '|',
                        'bold',
                        'italic',
                        'link',
                        'bulletedList',
                        'numberedList',
                        '|',
                        'outdent',
                        'indent',
                        '|',
                        'blockQuote',
                        'undo',
                        'redo'
                    ]
                }
            })
        })
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
            time_24hr: true,
            minDate: `{{ now()->format('Y-m-d') }}`,
        })
        $('.datetimepicker-unlimit').flatpickr({
            enableTime: true,
            time_24hr: true,
        })
        $('.hourPicker').flatpickr({
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            minTime: "00:00",
            maxTime: "23:30",
            time_24hr: true
        })
        $('.datepicker').flatpickr({
            minDate: `{{ now()->format('Y-m-d') }}`,
        })
        initSummernote('body .summernote')
        initSimpleSummernote()
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
        $('.magnifig-video').magnificPopup({
            disableOn: 700,
            type: 'iframe',
            mainClass: 'mfp-fade',
            removalDelay: 160,
            preloader: false,

            fixedContentPos: false
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
            $(e.currentTarget).find('.modal-body').html('')
        })

        $('body').on('click', '.ajax-modal-btn', function(e) {
            e.preventDefault();
            const btn = $(this)
            const modalSize = $(this).attr('data-modal-size') ?? 'modal-lg'
            const modalId = $(this).data().modalId ?? 'myDynamicModal'
            $(this).loading()
            var url = $(this).attr('data-link');
            const callback = $(this).attr('data-callback')
            const getDataFunc = $(this).attr('data-get-data-function');
            let payload = null;
            if (getDataFunc) {
                payload = eval(getDataFunc)
            }
            var ajaxElement = this
            if (url.indexOf('#') == 0) {
                $(url).modal('open');
            } else {
                $.get(url, payload)
                    .done(function(data) {
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
                if (form.length) {
                    form.submit()
                } else {
                    const callback = $(e.currentTarget).attr('data-callback')
                    if (callback) eval(callback);
                }
            }
        })
        $('body').on('click', '.submit-loading', function() {
            $(this).loading();
            $(this).parents('form').submit()
        })
        $(document).on('click', '.mass-checkbox-btn', (e) => {
            $(e.target).parents('table').children('tbody').find('.child-checkbox').prop('checked', $(e
                .target).is(':checked'))
        })
    })
</script>
@if (Session::has('success'))
    <script>
        toast.success(`{{ trans('toast.action_successful') }}`, `{{ session()->get('success') }}`);
    </script>
@endif
