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
                {{ $invoice->user->full_name }}
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
                Invoice Date:
                <strong>{{ \Carbon\Carbon::parse($invoice->created_at)->translatedFormat('l j F Y H:i a') }}</strong>
            </td>
            <td>
                {{ !empty($addrress) && $addrress->address != ''  ? $addrress->address : '' }}
            </td>
        </tr>
        <tr>
            <td>
                Invoice No: <strong>{{ $invoice->invoice_number }}</strong>
            </td>
            <td>
                {{ $invoice->user->email }}
            </td>
        </tr>
    </table>


    <table class="line-items-container">
        <thead>
        <tr>
            <th class="heading-quantity">No</th>
            <th class="heading-description">Order Number</th>
            <th class="heading-description">Date</th>
            <th class="heading-price">Price</th>
            <th class="heading-subtotal">Subtotal</th>
        </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
                <tr>
                    <td>{{ $loop->index+1 }}</td>
                    <td>{{ $order->order_number }}</td>
                    <td>{{ \Carbon\Carbon::parse($order->created_at)->translatedFormat('l j F Y H:i a') }}</td>
                    <td>{{ $order->paid != 0 ? 'تم السداد' : 'لم تسدد' }}</td>
                    <td>{{ $order->total .' '.env('APP_CURRENCY') }}</td>
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
            <td class="large total">{{ $invoice->total .' '.env('APP_CURRENCY') }}</td>
        </tr>
        </tbody>
    </table>

    <div class="footer">
        <div class="footer-info">
            <span>Mohamedfarh987@gmail.com</span> |
            <span>01147451963</span> |
            <span>4FARH</span>
        </div>
        <div class="footer-thanks">
            <img src="https://github.com/anvilco/html-pdf-invoice-template/raw/main/img/heart.png" alt="heart">
            <span>Thank you!</span>
        </div>
    </div>

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
