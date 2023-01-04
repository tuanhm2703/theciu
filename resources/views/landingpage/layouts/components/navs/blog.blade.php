<li>
    <a href="{{ route('client.blog.index') }}" class="sf-with-ul">Blog</a>

    <ul>
        @foreach ($blog_categories as $category)
            <li><a href="{{ route('client.blog.index', ['category' => $category->name]) }}">{{ $category->name }}</a>
            </li>
        @endforeach
    </ul>
</li>
