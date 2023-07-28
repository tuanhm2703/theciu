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
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
<script src="{{ asset('assets/js/filepond.jquery.js') }}"></script>
<script src="{{ asset('assets/js/jbvalidator.js') }}"></script>
<script src="{{ asset('assets/js/jquery.withinviewport.js') }}"></script>
<script src="{{ asset('assets/js/withinviewport.js') }}"></script>
<script src="{{ asset('assets/js/fontawesome.js') }}"></script>
<script src="{{ asset('assets/landingpage/js/jquery.magnific-popup.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap-treeview.min.js') }}"></script>
<script src="{{ asset('assets/js/summernote-map-plugin.js') }}"></script>
<script src="{{ getAssetUrl('assets/js/notyf.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/simple-notify@0.5.5/dist/simple-notify.min.js"></script>
<script
    src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/lang/summernote-{{ App::getLocale() }}-{{ getLocaleWithCountryCode()[App::getLocale()] }}.min.js">
</script>
{{-- <script type="text/javascript" src="{{ asset('assets/js/froala_editor.pkgd.min.js') }}"></script> --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/4.0.19/js/froala_editor.min.js"></script>
<script src="{{ asset('assets/js/argon-dashboard.js') }}"></script>

<script>
    const toast = {
        success: (title = '', content) => {
            var notyf = new Notyf();
            notyf.open({
                type: 'success',
                message: content,
                background: '#2dce89'
            });
        },
        error: (title, content) => {
            var notyf = new Notyf();
            notyf.error(content);
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
