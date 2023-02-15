@extends('landingpage.layouts.app')
@section('content')
    <main class="main">
        <livewire:client.product-list-component :keyword="$keyword" :categories="$categories" :params="$params"></livewire:client.product-list-component>
    </main><!-- End .main -->
@endsection
