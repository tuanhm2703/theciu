<div>
    <a href="#" class="search-toggle" role="button"><i class="icon-search"></i></a>
    <form action="{{ route('client.product.index') }}" method="get">
        <div class="header-search-wrapper search-wrapper-wide">
            <label for="q" class="sr-only">Search</label>
            <button class="btn btn-primary" type="submit"><i class="icon-search"></i></button>
            <input type="search" class="form-control" wire:model="keyword" name="keyword" autocomplete="off"
                placeholder="Tìm sản phẩm..." required>
            <div class="spinner-border spinner-border-sm" role="status" wire:loading wire:target="keyword">
                <span class="sr-only">Loading...</span>
            </div>
        </div><!-- End .header-search-wrapper -->
    </form>
    @if (count($search_products) != 0)
        <div class="autocomplete-items py-0" wire:ignore.self>
            @foreach ($search_products as $product)
                <div class="border-bottom">
                    <a href="{{ route('client.product.details', $product->slug) }}" class="header-keyword-picker row">
                        <div class="col-3">
                            <img src="{{ $product->image->path_with_domain }}" alt="" width="100">
                        </div>
                        <div class="col-9 pl-0">
                            {{ $product->name }} <br>
                            @component('components.product-price-label', compact('product'))
                            @endcomponent
                        </div>
                    </a>
                </div>
            @endforeach
            <a href="{{ route('client.product.index', ['keyword' => $keyword]) }}"
                class="text-center header-keyword-picker d-block p-3 autocomplete-view-more">
                {{ trans('labels.view_more') }}
            </a>
        </div>
    @endif
</div>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        $('input[name=keyword]').focusout(e => {
            const relatedElement = $($(e.relatedTarget)[0])
            const classes = relatedElement.attr('class')?.split(' ')
            if (classes) {
                if (classes.includes('header-keyword-picker')) {
                    window.location.replace(relatedElement.attr('href'));
                }
            }
            $('.header-search .autocomplete-items').addClass('d-none');
        })
        $('input[name=keyword]').focus(e => {
            $('.header-search .autocomplete-items').removeClass('d-none');
        })
    })
</script>
