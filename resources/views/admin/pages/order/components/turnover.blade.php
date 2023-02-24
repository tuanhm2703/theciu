<span>{{ format_currency_with_label($order->subtotal) }}</span><br>
<p class="text-sm">{{trans('labels.payment_methods.'.$order->payment_method->code)}}</p>
