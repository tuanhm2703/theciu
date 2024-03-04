@extends('landingpage.layouts.pages.profile.index')
@section('profile-content')
    <livewire:client.order-details :order="$order"/>
    {{-- @if ($order->subtotal >= 699000 && empty($order->bonus_note) && in_array($order->order_status, [App\Enums\OrderStatus::WAIT_TO_ACCEPT, App\Enums\OrderStatus::WAITING_TO_PICK]))
        <livewire:client.spinner-wheel :order="$order"/>
    @endif --}}
@endsection
