@extends('landingpage.layouts.pages.profile.index')
@section('profile-content')
    <livewire:client.order-details :order="$order"></livewire:client.order-details>
@endsection
