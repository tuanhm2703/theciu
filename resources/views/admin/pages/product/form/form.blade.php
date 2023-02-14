@push('style')
    <style>
        .table tbody tr:last-child td {
            border-width: 1px !important;
            border-top: 0px;
        }

        #attribute-table .apnd-img {
            float: none;
            margin: auto;
        }

        iframe {
            volume: silent;
        }

        .select2-container {
            width: 100% !important;
        }

        .img-input-wrapper .invalid-feedback {
            width: 400px;
            padding-top: 80px;
        }

        .img-input-wrapper .miv-validate-label {
            align-self: flex-end;
            width: 0;
        }
    </style>
@endpush
@include('admin.pages.product.form.steps.general_info')
@include('admin.pages.product.form.steps.sale_info')
@include('admin.pages.product.form.steps.detail_info')
@include('admin.pages.product.form.steps.shipment_info')
@include('admin.pages.product.form.steps.additional_info')
@include('admin.pages.product.form.steps.other_info')


<div class="min-height-150"></div>
<!-- Button trigger modal -->

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Chỉnh sửa ngành hàng</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row category-selector min-height-200">
                    <div class="col-md-4 category-level-1">
                        <div class="nav-wrapper position-relative end-0">
                            <ul class="nav nav-pills nav-fill flex-column p-1" role="tablist">
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-4 border-start category-level-2">
                        <div class="nav-wrapper position-relative end-0">
                            <ul class="nav nav-pills nav-fill flex-column p-1" role="tablist">
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-4 border-start category-level-3">
                        <div class="nav-wrapper position-relative end-0">
                            <ul class="nav nav-pills nav-fill flex-column p-1" role="tablist">
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="mt-3">
                    <p style="font-size: 15px">Đã chọn: <strong class="categories-selected"></strong></p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="save-category-btn" class="btn bg-gradient-primary"
                    disabled>{{ trans('form.save') }}</button>
            </div>
        </div>
    </div>
</div>
@push('js')
    @include('admin.pages.product.form.assets._script')
    <script>
        if($('input[name=is_reorder]:checked').val() == 1) {
            $('#reorder-day-selector').removeClass('d-none')
        }
        $('input[name=is_reorder]').on('change', (e) => {
            $('#reorder-day-selector').addClass('d-none')
            if(e.target.value == 1) {
                $('#reorder-day-selector').removeClass('d-none')
            }
        })
    </script>
@endpush
