@extends('admin.layouts.app')
@push('style')
    <style>
        .select2-container {
            width: 100% !important;
        }

        .tiktok {
            display: inline-block;
            background: url(https://cdn-app.kiotviet.vn/retailler/bundles/2023310939/tiktok-ico.svg) no-repeat center;
            background-size: contain;
            height: 15px;
            width: 15px;
            margin-top: -5px;
        }
        .lazada {
            display: inline-block;
            background: url(https://cdn-app.kiotviet.vn/retailler/bundles/2023310939/lazada-icon-active.png) no-repeat center;
            background-size: contain;
            height: 15px;
            width: 15px;
            margin-top: -5px;
        }
        .shopee {
            display: inline-block;
            background: url(https://cdn-app.kiotviet.vn/retailler/bundles/2023310939/shopee-icon-active.png) no-repeat center;
            background-size: contain;
            height: 15px;
            width: 15px;
            margin-top: -5px;
        }
    </style>
@endpush
@section('content')
    @include('admin.layouts.navbars.auth.topnav', ['title' => trans('nav.sync_warehouse')])
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h6>Cài đặt đồng bộ KiotViet</h6>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-center flex-column w-50 mx-auto align-items-center border p-3">
                    <div class="warehouse-logo">
                        <img src="https://logo.kiotviet.vn/KiotViet-Logo-Horizontal.svg" alt="">
                    </div>
                    <h6 class="text-uppercase mt-1">Chọn chi nhánh đồng bộ sản phẩm</h6>
                    <p>Hiện tại: <span id="current-branch"></span></p>
                    {!! Form::model($kiotSetting, [
                        'url' => route('admin.setting.warehouse.update'),
                        'method' => 'PUT',
                        'class' => 'kiot-config-form w-80',
                    ]) !!}
                    <div class="row">
                        <div class="col-6">
                            <label class="customer-label">Kho :</label>
                        </div>
                        <div class="col-6">
                            {!! Form::select(
                                'branchId',
                                $branches->pluck('otherProperties.branchName', 'id')->toArray(),
                                $kiotSetting->data['branchId'],
                                ['class' => 'select2'],
                            ) !!}
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-6">
                            <label class="form-label">Kênh bán hàng: </label>
                        </div>
                        <div class="col-6">
                            {!! Form::select(
                                'saleChannelId',
                                $sale_channels->pluck('name', 'id')->toArray(),
                                isset($kiotSetting->data['saleChannelId']) ? $kiotSetting->data['saleChannelId'] : null,
                                ['class' => 'sale-channel-selector'],
                            ) !!}
                        </div>
                    </div>
                    <livewire:admin.sync-kiot-warehouse-component></livewire:admin.sync-kiot-warehouse-component>
                    <div class="text-center d-flex mt-3 justify-content-between">
                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                        <a href="#" id="sync-btn" class="btn btn-success ms-1">Đồng bộ</a>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
        @include('admin.layouts.footers.auth.footer')
    </div>
@endsection
@push('js')
    <script>
        let syncPercent = 0
        const branchId = @json($kiotSetting->data['branchId']);
        const numberOfProductHaveToSync = @json($numberOfProductHaveToSync);
        if (branchId) {
            $('#current-branch').text($("select[name=branchId] option:selected").text())
        } else {
            $('#current-branch').text('Chưa chọn')
            $('#sync-btn').attr('disabled', true)
        }
        $('select[name=branchId]').on('change', (e) => {
            $('#sync-btn').attr('disabled', false)
            if (branchId != e.target.value) {
                $('#sync-btn').attr('disabled', true)
            }
        })

        $('.kiot-config-form').ajaxForm({
            beforeSend: () => {
                $('button[type=submit]').loading()
            },
            success: (res) => {
                tata.success(@json(trans('toast.action_successful')), res.data.message)
                setTimeout(() => {
                    window.location.reload()
                }, 1000);
            },
            error: (err) => {
                $('button[type=submit]').loading(false)
            }
        })
        $('#sync-btn').on('click', (e) => {
            e.preventDefault()
            $('.progress').css('opacity', 1)
            $('.progress').css('height', '25px')
            syncPercent = 0
            $('.progress-bar').css('width', `${syncPercent}%`)
            $('.progress-bar').text(`${syncPercent}%`)
            const numberOfPages = numberOfProductHaveToSync % 10 == 0 ? numberOfProductHaveToSync / 10 : Math.floor(
                numberOfProductHaveToSync / 10) + 1
            for (let page = 1; page <= numberOfPages; page++) {
                $.ajax({
                    url: `{{ route('admin.setting.warehouse.stock.sync') }}?page=${page}&pageSize=10`,
                    type: 'POST',
                    success: (res) => {
                        const oldSyncPercent = syncPercent
                        syncPercent = Math.floor(page / numberOfPages * 100);
                        syncPercent = syncPercent < oldSyncPercent ? oldSyncPercent : syncPercent
                        $('.progress-bar').css('width', `${syncPercent}%`)
                        $('.progress-bar').text(`${syncPercent}%`)
                        if (syncPercent == 100) {
                            tata.success(`{{ trans('toast.action_successful') }}`, 'Đồng bộ hoàn tất')
                            setTimeout(() => {
                                $('.progress').css('opacity', 0)
                                $('.progress').css('height', 0)
                            }, 1000);
                        }
                    }
                })
            }
        })
        window.addEventListener('update-percentage', event => {
            console.log(event.detail);
        })
        $(document).ready(() => {
            const options = @json($sale_channels->pluck('name', 'id')->toArray());

            function formatState(state) {
                let [name, img] = state.text.split('|')
                if (!state.id) {
                    return state.text;
                }
                var $state = $(
                    `<span class="${img}"></span> <span>${name}</span>`
                );
                return $state;
            };
            $('.sale-channel-selector').select2({
                templateResult: formatState,
                templateSelection: formatState
            })
        })
    </script>
@endpush
