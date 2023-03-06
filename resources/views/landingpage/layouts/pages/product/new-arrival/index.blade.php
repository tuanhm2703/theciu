@extends('landingpage.layouts.app')
@section('content')
    <main class="main">
        <livewire:client.new-arrival-product-list-component :type="$categoryType" :title="$title"></livewire:client.new-arrival-product-list-component>
    </main><!-- End .main -->
@endsection
