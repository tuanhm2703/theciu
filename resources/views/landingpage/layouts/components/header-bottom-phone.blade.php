<div class="mobile-menu-container">
    <div class="mobile-menu-wrapper">
        <span class="mobile-menu-close"><i class="icon-close"></i></span>

        <form action="#" method="get" class="mobile-search">
            <label for="mobile-search" class="sr-only">Search</label>
            <input type="search" class="form-control" name="mobile-search" id="mobile-search" placeholder="Search in..."
                required>
            <button class="btn btn-primary" type="submit"><i class="icon-search"></i></button>
        </form>

        <nav class="mobile-nav">
            <ul class="mobile-menu">
                <li class="active">
                    <a href="/">Trang chủ</a>
                </li>
                <li>
                    <a href="#">New</a>
                    <ul>
                        @foreach ($new_arrival_categories as $c)
                            <li>
                                <a
                                    href="{{ route('client.product.index', ['category' => $c->slug]) }}">{{ $c->name }}</a>
                            </li>
                        @endforeach
                    </ul>
                </li>
                <li>
                    <a href="#" class="sf-with-ul">Sản phẩm</a>

                    <ul>
                        @foreach ($product_categories as $c)
                            {!! renderCategory($c) !!}
                        @endforeach
                    </ul>
                </li>

                <li>
                    <a href="#">Sale</a>
                    <ul>
                        @foreach ($promotions as $p)
                            <li><a
                                    href="{{ route('client.product.index', ['promotion' => $p->slug]) }}">{{ $p->name }}</a>
                            </li>
                        @endforeach
                    </ul>
                </li>
                <li>
                    <a href="blog.html">Blog</a>

                    <ul>
                        @foreach ($blog_categories as $category)
                            <li><a
                                    href="{{ route('client.blog.index', ['category' => $category->name]) }}">{{ $category->name }}</a>
                            </li>
                        @endforeach
                    </ul>
                </li>
            </ul>
        </nav><!-- End .mobile-nav -->

        <div class="social-icons">
            <a href="#" class="social-icon" target="_blank" title="Facebook"><i class="icon-facebook-f"></i></a>
            <a href="#" class="social-icon" target="_blank" title="Twitter"><i class="icon-twitter"></i></a>
            <a href="#" class="social-icon" target="_blank" title="Instagram"><i class="icon-instagram"></i></a>
            <a href="#" class="social-icon" target="_blank" title="Youtube"><i class="icon-youtube"></i></a>
        </div><!-- End .social-icons -->
    </div><!-- End .mobile-menu-wrapper -->
</div><!-- End .mobile-menu-container -->
