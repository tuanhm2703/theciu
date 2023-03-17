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
    @if (count($autocompleteKeywords) != 0)
        <div class="autocomplete-items" wire:ignore.self>
            @foreach ($autocompleteKeywords as $item)
                <div>
                    <a href="{{ route('client.product.index', ['keyword' => $item->name]) }}"
                        class="header-keyword-picker">
                        {{ $item->name }}
                    </a>
                </div>
            @endforeach
        </div>
    @endif
</div>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        $('input[name=keyword]').focusout(e => {
            const relatedElement = $($(e.relatedTarget)[0])
            if (relatedElement.attr('class') == 'header-keyword-picker') {
                window.location.href = relatedElement.attr('href');
            }
            $('.header-search .autocomplete-items').addClass('d-none');
        })
        $('input[name=keyword]').focus(e => {
            $('.header-search .autocomplete-items').removeClass('d-none');
        })
    })
</script>
