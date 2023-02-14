<div class="row">
    @foreach ($products as $product)
        <div class="col-6 col-md-4 col-lg-4 col-xl-3">
            <livewire:client.product-card-component :product="$product"></livewire:client.product-card-component>
        </div>
    @endforeach
</div>
