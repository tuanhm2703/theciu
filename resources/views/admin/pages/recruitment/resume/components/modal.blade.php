<div class="p-5">
    @include('admin.pages.recruitment.resume.components.table')
</div>
<script>
    (() => {
        $('.resume-table').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "{{ route('admin.recruitment.resume.paginate') }}",
            "columns": [{
                    data: 'id',
                    render: function(data, type, full, meta) {
                        const info = table.page.info()
                        const rowNumber = meta.row + 1;
                        return (info.page) * info.length + rowNumber

                    }
                },
                {
                    data: "jd.name",
                },
                {
                    data: "fullname"
                },
                {
                    data: "phone"
                },
                {
                    data: "email",
                },
                {
                    data: "created_at",
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
