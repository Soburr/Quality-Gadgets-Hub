@if ($shipment->isCancelled)
    <div class="ui-layout__item mb20">
        <div class="ui-banner ui-banner--status-warning">
            <div class="ui-banner__ribbon">
                <svg class="svg-next-icon svg-next-icon-size-20">
                    <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#alert-circle"></use>
                </svg>
            </div>
            <div class="ui-banner__content">
                <h2 class="ui-banner__title">{{ trans('plugins/ecommerce::shipping.shipment_canceled') }}</h2>
                <div class="ws-nm">
                    {{ trans('plugins/ecommerce::shipping.at') }} <i>{{ BaseHelper::formatDate($shipment->updated_at, 'H:i d/m/Y') }}</i>
                </div>
            </div>
        </div>
    </div>
@endif
