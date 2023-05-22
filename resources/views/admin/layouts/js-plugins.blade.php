<script src="{{ asset('assets/js/jquery-3.6.1.min.js') }}"></script>
<script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
<script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/smooth-scrollbar.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/multiple-image-video.js') }}"></script>
<script src="{{ asset('assets/js/plugins/tata/tata.js') }}"></script>
<script src="{{ asset('assets/js/jquery-ui.js') }}"></script>
<script src="{{ asset('assets/js/select2-4.0.0.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.form.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/js/dataTables.bootstrap5.min.js') }}"></script>
<script src="{{ asset('assets/js/dataTables.select.min.js') }}"></script>
<script src="{{ asset('assets/js/datatable-language.js') }}"></script>
<script src="{{ asset('assets/js/jquery-confirm.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/filepond/filepond.js') }}"></script>
<script src="{{ asset('assets/js/app.js') }}"></script>
<script src="{{ asset('assets/js/flatpickr.min.js') }}"></script>
<script src="{{ asset('assets/js/filepond-plugin-image-preview.js') }}"></script>
<script src="{{ asset('assets/js/summernote.js') }}"></script>
<script src="{{ asset('assets/js/filepond.jquery.js') }}"></script>
<script src="{{ asset('assets/js/jbvalidator.js') }}"></script>
<script src="{{ asset('assets/js/jquery.withinviewport.js') }}"></script>
<script src="{{ asset('assets/js/withinviewport.js') }}"></script>
<script src="{{ asset('assets/js/fontawesome.js') }}"></script>
<script src="{{ asset('assets/landingpage/js/jquery.magnific-popup.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap-treeview.min.js') }}"></script>
<script src="{{ asset('assets/js/summernote-map-plugin.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote.min.js"></script>
<script
    src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/lang/summernote-{{ App::getLocale() }}-{{ getLocaleWithCountryCode()[App::getLocale()] }}.min.js">
</script>
<script src="{{ asset('assets/js/argon-dashboard.js') }}"></script>
<script>
    const toast = {
        success: (title, content, duration = 2000) => {
            new Notify({
                status: 'success',
                title: title,
                text: content,
                effect: 'fade',
                speed: 300,
                customClass: '',
                customIcon: '',
                showIcon: true,
                showCloseButton: true,
                autoclose: true,
                autotimeout: duration,
                gap: 20,
                distance: 20,
                type: 1,
                position: 'center'
            })
        },
        error: (title, content, duration = 2000) => {
            new Notify({
                status: 'error',
                title: title,
                text: content,
                effect: 'fade',
                speed: 300,
                customClass: '',
                customIcon: '',
                showIcon: true,
                showCloseButton: true,
                autoclose: true,
                autotimeout: duration,
                gap: 20,
                distance: 20,
                type: 1,
                position: 'center'
            })
        }
    }
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
        var options = {
            damping: '0.5'
        }
        Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
</script>
