@extends('landingpage.layouts.app')
@section('content')
    <main class="main">
        <div>
            <nav aria-label="breadcrumb" class="breadcrumb-nav mb-2">
                <div class="container">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">{{ trans('labels.dashboard') }}</a></li>
                        <li class="breadcrumb-item"><a href="#">Combo khuyến mãi</a></li>
                    </ol>
                </div><!-- End .container -->
            </nav><!-- End .breadcrumb-nav -->
            <div class="page-content">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            @foreach ($combos as $combo)
                                <h3 class="text-center text-secondary">
                                    {{ $combo->name }}
                                </h3>
                                <div class="row">
                                    @foreach ($combo->products as $product)
                                        <div class="col-6 col-md-3">
                                            <livewire:client.product-card-component wire:ignore
                                                wire:key="product-{{ $product->id . time() }}" :product="$product">
                                            </livewire:client.product-card-component>
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                        </div><!-- End .col-lg-9 -->
                    </div><!-- End .row -->
                </div><!-- End .container -->
            </div><!-- End .page-content -->
        </div>
    </main><!-- End .main -->
@endsection
