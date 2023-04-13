<div class="row">
    <aside class="col-md-3 col-lg-2">
        <ul class="nav nav-dashboard flex-column mb-3 mb-md-0" role="tablist">
            <li class="nav-item">

                <a class="nav-link {{ $content == 'order-list' ? 'active' : '' }}"
                    id="content-tab" data-toggle="tab" href="#tab-content" role="tab" aria-controls="tab-orders"
                    aria-selected="false"><i class="fas fa-shopping-cart text-light"></i>
                    {{ trans('labels.order_list') }}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ $content == 'address' ? 'active' : '' }}"  id="content-tab" data-toggle="tab"
                    href="#tab-content" role="tab" role="tab" aria-controls="tab-address"
                    aria-selected="false"><i class="fa fa-location-arrow text-light" aria-hidden="true"></i>
                    {{ trans('labels.address') }}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ $content == 'profile' ? 'active' : '' }}" id="content-tab" data-toggle="tab"
                    href="#tab-content" role="tab" role="tab" aria-controls="tab-account"
                    aria-selected="false"><i class="fa fa-user text-light" aria-hidden="true"></i>
                    {{ trans('labels.account_info') }}</a>
            </li>
        </ul>
    </aside><!-- End .col-lg-3 -->
    <div class="col-md-9 col-lg-10">
        <div class="tab-content">
            <div class="tab-pane active" id="tab-content" role="tabpanel" aria-labelledby="tab-orders-link" style="min-height: 50vh">
                <div class="text-center" wire:loading>Loading...</div>
                <div class="page-content container w-100" wire:loading.remove>
                    @switch($content)
                        @case('order-list')
                            <livewire:order-list-component></livewire:order-list-component>
                        @break

                        @case('address')
                            <livewire:profile-address-info></livewire:profile-address-info>
                        @break

                        @case('profile')
                            <livewire:profile-info-component></livewire:profile-info-component>
                        @break
                        @case('order-details')
                            <livewire:client.order-details :orde="$order"></livewire:client.order-details>
                        @break
                    @endswitch
                </div><!-- End .page-content -->
            </div><!-- .End .tab-pane -->
        </div>
    </div><!-- End .col-lg-9 -->
</div>
