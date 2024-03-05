<div class="p-5">
    @include('admin.pages.recruitment.resume.components.table')
</div>
<script>
    (() => {
        const table = $('.resume-table').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "{{ route('admin.recruitment.resume.paginate') }}",
            "columns": [
                {
                    data: 'id',
                    render: function(data, type, full, meta) {
                        const info = table.page.info()
                        const rowNumber = meta.row + 1;
                        return (info.page) * info.length + rowNumber

                    }
                },
                {
                    data: "candidate"
                },
                {
                    data: "jd.name",
                },
                {
                    data: "contact_info",
                },
                {
                    data: "insign",
                },
                {
                    data: "action",
                },
            ],
            order: [
                [0, 'desc']
            ],
        });
    })()
</script>
