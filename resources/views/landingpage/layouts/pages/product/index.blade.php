@extends('landingpage.layouts.app')
@push('css')
    <style>
        .page-content span {
            width: fit-content !important;
            height: fit-content !important;
        }
        .product-countdown .countdown-show4 .countdown-section {
            width: calc(25% - 10px) !important;
            height: auto !important;
        }
    </style>
@endpush
@section('content')
    <livewire:client.product-list-component :banners="isset($banners) ? $banners : []" :category="$category ?? null" :haspromotion="isset($haspromotion)" :type="isset($type) ? $type : null"
        :title="isset($title) ? $title : null" :promotion="isset($promotion) ? $promotion : null" />
        @isset($description)
    @endisset
@endsection
