@extends('landingpage.layouts.app')
@section('content')
    <main class="main">
        <livewire:client.product-list-component :type="$categoryType" :title="$title"></livewire:client.product-list-component>
    </main><!-- End .main -->
@endsection
