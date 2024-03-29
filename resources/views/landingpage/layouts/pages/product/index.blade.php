@extends('landingpage.layouts.app')
@push('css')
    <style>
        .page-content span {
            width: fit-content !important;
            height: fit-content !important;
        }

        .product-countdown .countdown-show4 .countdown-section span {
            width: 100% !important;
            height: auto !important;
        }

        .product-countdown .countdown-show4 .countdown-section {
            width: calc(25% - 10px) !important;
        }
    </style>
@endpush
@section('content')
    <livewire:client.product-list-component :banners="isset($banners) ? $banners : []" :category="$category ?? null" :haspromotion="isset($haspromotion)" :type="isset($type) ? $type : null"
        :title="isset($title) ? $title : null" :promotion="isset($promotion) ? $promotion : null" />
    @isset($description)
    @endisset
@endsection
