<div>
    <form action="{{ route('client.product.index') }}" method="get" class="mobile-search position-relative">
        <label for="mobile-search" class="sr-only">Search</label>
        <input wire:model="keyword" type="search" class="form-control" name="mobile-search" id="mobile-search"
            placeholder="{{ trans('labels.search') }}...">
        <button class="btn btn-primary" type="submit">
            <div class="spinner-border spinner-border-sm" height="18px" role="status" wire:loading wire:target="keyword">
                <span class="sr-only">Loading...</span>
            </div>
            <i class="icon-search ml-0" wire:loading.remove></i></button>
        @if (count($search_products) != 0)
            <div class="autocomplete-items py-0" wire:ignore.self>
                @foreach ($search_products as $product)
                    <div class="border-bottom">
                        <a href="{{ route('client.product.details', $product->slug) }}"
                            class="mobile-keyword-picker row">
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
    </form>
</div>
<script>
     document.addEventListener("DOMContentLoaded", () => {
        $('input[name=mobile-search]').focusout(e => {
            console.log('hello');
            const relatedElement = $($(e.relatedTarget)[0])
            const classes = relatedElement.attr('class')?.split(' ')
            if (classes) {
                if (classes.includes('mobile-keyword-picker')) {
                    window.location.href = relatedElement.attr('href');
                }
            }
            $('.mobile-search .autocomplete-items').addClass('d-none');
        })
        $('input[name=mobile-search]').focus(e => {
            $('.mobile-search .autocomplete-items').removeClass('d-none');
        })
    })
</script>
