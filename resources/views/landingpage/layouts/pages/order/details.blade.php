@extends('landingpage.layouts.pages.profile.index')
@section('profile-content')
    <livewire:client.order-details :order="$order"></livewire:client.order-details>
    @if ($order->subtotal >= 699000 && empty($order->bonus_note))
        <livewire:client.spinner-wheel :order="$order"/>
    @endif
@endsection
