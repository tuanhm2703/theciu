@if ($voucher->id !== $review_voucher?->id)
    {!! Form::open([
        'method' => 'POST',
        'url' => route('admin.review.setting.voucher'),
    ]) !!}
    {!! Form::hidden('voucher_id', $voucher->id, []) !!}
    <button type="button" class="btn btn-success submit-loading">Sử dụng</button>
    {!! Form::close() !!}
@else
    {!! Form::open([
        'method' => 'DELETE',
        'url' => route('admin.review.setting.voucher'),
    ]) !!}
    <button type="button" class="btn btn-danger submit-loading">Huỷ</button>
    {!! Form::close() !!}
@endif
