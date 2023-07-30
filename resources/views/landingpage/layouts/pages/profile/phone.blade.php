@extends('landingpage.layouts.pages.profile.index')
@section('profile-content')
    <livewire:client.update-phone-component :phone="$phone"/>
@endsection
