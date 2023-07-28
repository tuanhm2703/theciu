<div class="card">
    <div class="card-header">
        <h6 class="mb-1">Review #{{ $review->id }}</h6>
        <i>{{ $review->details }}</i>
    </div>
    <div class="card-body pt-0">
        <div id="carouselExample" class="carousel slide">
            <div class="carousel-inner">
                @if ($image->type === App\Enums\MediaType::VIDEO)
                    <div class="w-100 carousel-item">
                        <video id="my-player" class="video-js" controls preload="auto" data-setup='{}'>
                            <source src="{{ $review->video->path_with_domain }}" type="video/mp4" />
                        </video>
                    </div>
                @endif
                @foreach ($review->images as $index => $image)
                    <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                        <img src="{{ $image->path_with_domain }}" class="d-block w-100" alt="...">
                    </div>
                @endforeach

            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
        {!! Form::model($review, [
            'url' => route('admin.review.reply.update', $review->id),
            'method' => 'PUT',
            'class' => 'review-form',
        ]) !!}
        {!! Form::label('reply', trans('labels.content') . ': ', ['class' => 'custom-label-control m-0']) !!}
        {!! Form::textarea('reply', null, ['class' => 'form-control summernote-simple']) !!}
        <div class="text-end mt-3">
            {!! Form::submit(trans('labels.reply'), ['class' => 'btn btn-primary']) !!}
        </div>
        {!! Form::close() !!}
    </div>
</div>
<script>
    (() => {
        $('.review-form').ajaxForm({
            beforeSubmit: () => {
                $('.review-form [type=submit]').loading()
            },
            success: (res) => {
                toast.success(`{{ trans('toast.action_successful') }}`, res.data.message);
                table.ajax.reload()
                $('.modal.show').modal('hide')
            },
        })
    })()
</script>
@if ($review->video)
    <script>
        (() => {
            var player = videojs('my-player');
        })()
    </script>
@endif
