<div class="widget widget-cats">
    <h3 class="widget-title">Danh mục</h3><!-- End .widget-title -->
    <ul>
        @foreach ($categories as $category)
            <li><a
                    href="{{ route('client.blog.index', ['category' => $category->name]) }}">{{ $category->name }}<span>{{ $category->blogs_count }}</span></a>
            </li>
        @endforeach
    </ul>
</div><!-- End .widget -->
