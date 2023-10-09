@extends('landingpage.layouts.app')
@push('css')
    <style>
        .page-content img {
            width: 100% !important;
        }
        .page-content span {
            width: fit-content;
            height: fit-content;
        }
    </style>
@endpush
@section('content')
    <livewire:client.product-list-component :banners="isset($banners) ? $banners : []" :category="$category ?? null" :haspromotion="isset($haspromotion)" :type="isset($type) ? $type : null"
        :title="isset($title) ? $title : null" :promotion="isset($promotion) ? $promotion : null" />
        @isset($description)
    @endisset
@endsection
