<div class="card p-5">
    <div class="card-header mb-3">
        <h5>Đánh giá sản phẩm</h5>
    </div>
    <div class="card-body p-0">
        @foreach ($order->inventories as $inventory)
            <div class="row">
                <div class="col-2">
                    <img src="{{ $inventory->image->path_with_domain }}" alt="">
                </div>
                <div class="col-10">
                    <h6>{{ $inventory->name }}</h6>
                    <p>Phân loại hàn: {{ $inventory->title }}</p>
                </div>
            </div>
        @endforeach
        <div class="bg-light p-3 mt-3">
            <div class="p-3 border bg-white">
                <div class="form-group mb-1">
                    <label for="exampleInputEmail1" class="mb-0 font-weight-bold">Màu sắc</label>
                    <input type="email" class="form-control border-0 pl-0" placeholder="Để lại đánh giá">
                </div>
                <div class="form-group mb-1">
                    <label for="exampleInputPassword1" class="mb-0 font-weight-bold">Đúng với mô tả</label>
                    <input type="text" class="form-control border-0 pl-0">
                </div>
                <div class="form-group mb-1">
                    <label for="exampleInputPassword1" class="mb-0 font-weight-bold">Chất liệu</label>
                    <input type="text" class="form-control border-0 pl-0">
                </div>
                <div class="form-group border-top">
                    <textarea class="form-control border-0 pl-0"
                        placeholder="Hãy chia sẻ những điều bạn thích về sản phẩm này với những người mua khác nhé."></textarea>
                </div>
            </div>
            <div class="d-flex">
                <div class="d-flex">
                    <div class="img-gallery"></div>
                    <x-admin.bordered-add-btn text="Thêm hình ảnh" class="img-drag">
                        <svg viewBox="0 0 23 21" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M18.5 0A1.5 1.5 0 0 1 20 1.5V12c-.49-.07-1.01-.07-1.5 0V1.5H2v12.65l3.395-3.408a.75.75 0 0 1 .958-.087l.104.087L7.89 12.18l3.687-5.21a.75.75 0 0 1 .96-.086l.103.087 3.391 3.405c.81.813.433 2.28-.398 3.07A5.235 5.235 0 0 0 14.053 18H2a1.5 1.5 0 0 1-1.5-1.5v-15A1.5 1.5 0 0 1 2 0h16.5z">
                            </path>
                            <path
                                d="M6.5 4.5a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3zM18.5 14.25a.75.75 0 0 1 1.5 0v2.25h2.25a.75.75 0 0 1 0 1.5H20v2.25a.75.75 0 0 1-1.5 0V18h-2.25a.75.75 0 0 1 0-1.5h2.25v-2.25z">
                            </path>
                        </svg>
                    </x-admin.bordered-add-btn>
                </div>
                <div class="d-flex">
                    <div class="video-gallery"></div>
                    <x-admin.bordered-add-btn text="Thêm video" class="video-drag">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16">
                            <path
                                d="M13 2a1 1 0 0 1 1 1v7.035a3.538 3.538 0 0 0-1 0V3H2v10h8.035a3.538 3.538 0 0 0 0 1H2a1 1 0 0 1-1-1V3a1 1 0 0 1 1-1h11z">
                            </path>
                            <path
                                d="M6 5.667c0-.481.549-.755.933-.467l3.111 2.333c.312.234.312.7 0 .934L6.934 10.8A.583.583 0 0 1 6 10.333V5.667zm7 5.833a.5.5 0 0 1 1 0V13h1.5a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0V14h-1.5a.5.5 0 0 1 0-1H13v-1.5z">
                            </path>
                        </svg>
                    </x-admin.bordered-add-btn>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $('.img-gallery').miv({
        dragBtn: '.img-drag',
        inputName: 'images',
        maxFile: 5,
        sortable: false,
        required: true,
        showThumb: true,
    });
</script>
