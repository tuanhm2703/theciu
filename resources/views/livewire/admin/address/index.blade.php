<div>
    @foreach ($addresses as $address)
        @component('admin.pages.setting.address.components.address', compact('address'))
        @endcomponent
    @endforeach
</div>
