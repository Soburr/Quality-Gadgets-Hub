@extends(MarketplaceHelper::viewPath('dashboard.layouts.master'))
@section('content')
    <div class="max-width-1200">
        @include('plugins/ecommerce::shipments.notification')

        <div class="flexbox-grid no-pd-none">
            <div class="flexbox-content">
                @include('plugins/ecommerce::shipments.products', [
                        'productEditRouteName' => 'marketplace.vendor.products.edit',
                        'orderEditRouteName' => 'marketplace.vendor.orders.edit',
                    ])

                @include('plugins/ecommerce::shipments.form', [
                        'updateStatusRouteName' => 'marketplace.vendor.orders.update-shipping-status',
                        'updateCodStatusRouteName' => 'marketplace.vendor.shipments.update-cod-status',
                    ])

                @include('plugins/ecommerce::shipments.histories')
            </div>

            @include('plugins/ecommerce::shipments.information', ['orderEditRouteName' => 'marketplace.vendor.orders.edit'])
        </div>
    </div>
    {!! Form::modalAction('confirm-change-status-modal', trans('plugins/ecommerce::shipping.change_status_confirm_title'), 'info', trans('plugins/ecommerce::shipping.change_status_confirm_description'), 'confirm-change-shipment-status-button', trans('plugins/ecommerce::shipping.accept')) !!}
@stop
