@extends('landingpage.layouts.app')
@section('content')
    <main class="main">
        <livewire:client.promotion-product-list-component :title="$title" :promotion="$promotion"></livewire:client.promotion-product-list-component>
    </main><!-- End .main -->
@endsection
