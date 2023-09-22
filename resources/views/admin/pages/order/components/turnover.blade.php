<span>{{ format_currency_with_label($order->getFinalRevenue()) }}</span><br>
<p class="text-sm">{{trans('labels.payment_methods.'.$order->payment_method->code)}}</p>
