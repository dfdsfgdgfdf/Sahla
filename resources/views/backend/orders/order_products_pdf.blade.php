<!doctype html>
<html class="no-js" lang="">

<head>
    <meta charset="utf-8">
    <title>Invoice Template</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="{{ asset('invoice') }}/web/modern-normalize.css">
    <link rel="stylesheet" href="{{ asset('invoice') }}/web/web-base.css">
    <link rel="stylesheet" href="{{ asset('invoice') }}/invoice.css">
    <script type="text/javascript" src="{{ asset('invoice') }}/web/scripts.js"></script>
</head>
<body>
@php
    $addrress = \App\Models\UserAddress::whereUserId($order->user_id)->whereDefaultAddress(1)->first();
@endphp
<div class="web-container">

    <div class="page-container">
        Page
        <span class="page"></span>
        of
        <span class="pages"></span>
    </div>

    <div class="logo-container">
        {{--        <img--}}
        {{--            style="height: 18px"--}}
        {{--            src="https://app.useanvil.com/img/email-logo-black.png"--}}
        {{--        >--}}
        <h1>SAHLA</h1>
    </div>

    <table class="invoice-info-container">
        <tr>
            <td rowspan="2" class="client-name">
                {{ $order->user->full_name }}
            </td>
            <td>
                {{ !empty($addrress) && $addrress->country_id != ''  ? $addrress->country->name : '' }}
            </td>
        </tr>
        <tr>
            <td>
                {{ !empty($addrress) && $addrress->state_id != ''  ? $addrress->state->name : '' }}
            </td>
        </tr>
        <tr>
            <td>
                Invoice Date: <strong>{{ \Carbon\Carbon::parse($order->created_at)->translatedFormat('l j F Y H:i a') }}</strong>
            </td>
            <td>
                {{ !empty($addrress) && $addrress->address != ''  ? $addrress->address : '' }}
            </td>
        </tr>
        <tr>
            <td>
                Invoice No: <strong>{{ $order->order_number }}</strong>
            </td>
            <td>
                {{ $order->user->email }}
            </td>
        </tr>
    </table>


    <table class="line-items-container">
        <thead>
        <tr>
            <th class="heading-quantity">Qty</th>
            <th class="heading-description">Name</th>
            <th class="heading-price">Price</th>
            <th class="heading-subtotal">Subtotal</th>
        </tr>
        </thead>
        <tbody>
        @php
            $orderProducts = \App\Models\OrderProduct::whereOrderId($order->id)->get();
            $total = 0;
        @endphp
        @foreach($orderProducts as $product)
            @php $total += $product->price * $product->quantity; @endphp
            <tr>
                <td>{{ $product->quantity }}</td>
                <td>{{ $product->name }}</td>
                <td class="right">{{ $product->price .' '. env('APP_CURRENCY') }}</td>
                <td class="bold">{{ $product->quantity * $product->price .' '. env('APP_CURRENCY') }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>


    <table class="line-items-container has-bottom-border">
        <thead>
        <tr>
            <th></th>
            <th></th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td class="large">
                <div>
                    Total
                </div>
            </td>
            <td class="large"></td>
            <td class="large total">{{ $total .' '.env('APP_CURRENCY') }}</td>
        </tr>
        </tbody>
    </table>

    @include('layouts.backend.invoiceFooter')

</div>

<script type="text/javascript">
    load(document.querySelector('.web-container'), '{{ asset('backend/order.invoice') }}');
    // From https://stackoverflow.com/a/32144585
    function load(target, url) {
        var r = new XMLHttpRequest();
        r.open("GET", url, true);
        r.onreadystatechange = function () {
            if (r.readyState != 4 || r.status != 200) return;
            target.innerHTML = r.responseText;
        };
        r.send();
    }
</script>

</body>
</html>
