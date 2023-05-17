<div id="batch-create-wrapper" wire:ignore.self>
    <div class="row mt-3">
        <div class="offset-4 col-8 offset-lg-2 col-lg-4" wire:ignore>
            <div class="form-check">
                {!! Form::checkbox('batch-create', null, false, ['class' => 'form-check-input', 'id' => 'batch-create']) !!}
                {!! Form::label('batch-create', 'Tạo voucher hàng loạt', ['class' => 'custom-control-label']) !!}
            </div>
        </div>
    </div>
    <div class="row mt-3" id="voucher-code-list">
        <div class="offset-4 col-8 offset-lg-2 col-lg-4" style="max-height: 700px; overflow: scroll">
            <table class="table">
                <thead class="position-sticky top-0 bg-white">
                    <tr>
                        <td clas="text-secondary text-xxs">STT</td>
                        <td clas="text-secondary text-xxs">Mã voucher</td>
                        <td clas="text-secondary text-xxs">Thao tác</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($codes as $index => $code)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>
                                {!! Form::text("codes[$index]", $code, [
                                    'wire:change' => 'updateCodeFromArray(' . $index . ', $event.target.value)',
                                    'max-length' => '10',
                                    'required',
                                    'class' => 'form-control',
                                ]) !!}
                            </td>
                            <td class="text-center"><i wire:click="removeCodeFromArray({{ $index }})"
                                    class="fas fa-times text-danger"></i></td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot class="border-none border-top position-sticky bottom-0 bg-white">
                    <tr>
                        <td colspan="3">
                            <button data-bs-toggle="modal" data-bs-target="#batchCreateVoucherCodeModal"
                                class="btn btn-success w-100" type="button">
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"
                                    wire:target="addCode" wire:loading></span>
                                <span wire:target="addCode" wire:loading.remove>Thêm mã voucher</span>
                            </button>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    <div class="modal fade" id="batchCreateVoucherCodeModal" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalSignTitle" wire:ignore.self aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body p-0">
                    <div class="card">
                        <div class="card-header p-0"></div>
                        <div class="card-body">
                            <div class="">
                                {!! Form::label('codeQuantity', trans('labels.quantity'), ['class' => 'custom-control-label']) !!}
                                {!! Form::number('codeQuantity', 1, ['class' => 'form-control']) !!}
                                @error('codeQuantity')
                                    <small class="text-danger">
                                        <i>{{ $message }}</i>
                                    </small>
                                @enderror
                            </div>
                            <div class=" mt-3">
                                {!! Form::label('codePrefix', 'Đầu mã voucher', ['class' => 'custom-control-label']) !!}
                                {!! Form::text('codePrefix', null, ['class' => 'form-control', 'max-length' => '4', 'min-length' => '2']) !!}
                                @error('codePrefix')
                                    <small class="text-danger">
                                        <i>{{ $message }}</i>
                                    </small>
                                    <br>
                                @enderror
                                <small class="mt-1"><i>Ví dụ: Với đầu mã voucher "VMK", hệ thống sẽ tự động tạo ra những ký tự ngẫu nhiên còn lại cho voucher (VMKEDF123, VMKEDX114, ...)</i></small>
                            </div>
                        </div>
                        <div class="card-footer pt-0 text-end">
                            <button class="btn btn-primary" id="batchCreateVoucherCodeBtn">
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"
                                    wire:loading></span>
                                <span wire:loading.remove>Tạo</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('js')
    <script>
        $('#batchCreateVoucherCodeBtn').on('click', (e) => {
            e.preventDefault();
            @this.addCode($('input[name=codeQuantity]').val(), $('input[name=codePrefix]').val())
            @this.on('closeModal', () => {
                $('.modal.show').modal('hide')
            })
        })
    </script>
@endpush
