<div class="card mx-3">
    <div class="card-header pb-0">
        <h6 class="text-uppercase">thông tin câu trả lời</h6>
    </div>
    <div class="card-body pt-0">
        <div class="mb-3">
            <h6>Hãy giới thiệu sơ lược về bản thân</h6>
            <div>
                {!! $resume->self_introduce !!}
            </div>
        </div>
        <div class="mb-3">
            <h6>Tại sao bạn thấy phù hợp với công việc này</h6>
            <div>
                {!! $resume->strength !!}
            </div>
        </div>
        <div class="mb-3">
            <h6>Bạn có câu hỏi nào cần giải đáp</h6>
            <div>
                {!! $resume->question !!}
            </div>
        </div>

    </div>
</div>
