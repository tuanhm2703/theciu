@extends('admin.layouts.app')
@section('content')
    @include('admin.layouts.navbars.auth.topnav', ['title' => 'Website'])
    <div class="container-fluid">
        <div class="container-fluid">
            <x-admin.card header="Website">
                <textarea name="" id="" cols="30" rows="10" class="form-control"></textarea>
            </x-admin.card>

            @include('admin.layouts.footers.auth.footer')
        </div>
        @include('admin.layouts.footers.auth.footer')
    </div>
@endsection
@push('js')

@endpush
