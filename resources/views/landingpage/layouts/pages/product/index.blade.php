@extends('landingpage.layouts.app')
@section('content')
    <main class="main">
        <livewire:client.product-list-component :haspromotion="isset($haspromotion)" :type="isset($type) ? $type : null" :title="isset($title) ? $title : null" :promotion="isset($promotion) ? $promotion : null" />
    </main><!-- End .main -->
@endsection
