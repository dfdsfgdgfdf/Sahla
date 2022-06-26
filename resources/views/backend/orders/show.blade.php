@extends('layouts.auth_admin_app')

@section('title', 'تقاصيل الطلب')

@section('content')

    <section class="my-cart">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-xs-12">
                    <div class="row">
                        @foreach($orderProducts as $orderProduct)
                            <div class="col-md-12 col-xs-12">
                                <div class="card mb-3">
                                    <div class="row no-gutters">
                                        <div class="col-md-4">
                                            <img src="{{ asset($orderProduct->image) }}" class="card-img" alt="...">
                                        </div>
                                        <div class="col-md-8">
                                            <div class="card-body">
                                                <a href="{{ route('admin.products.show', $orderProduct->product_id) }}">
                                                    <h5 class="card-title">{{ $orderProduct->name }}</h5>
                                                </a>
                                                <h5 class="card-title text-hover-success">{{ $orderProduct->price .' '. env('APP_CURRENCY') }}</h5>
                                                <h5 class="card-title text-success">  الوحدة : {{ $orderProduct->unit->name_ar }} </h5>
                                                <h5 class="card-title text-success"> الكمية المطلوبة : {{ $orderProduct->quantity }} </h5>
                                                <p class="card-text">{{ $orderProduct->product->description_ar }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-md-4 col-xs-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">رقم الطلب : {{ $orderProduct->order->order_number }}</h5>
                            <h5 class="card-title">تاريخ الطلب : {{ \Carbon\Carbon::parse($orderProduct->created_at)->translatedFormat('l j F Y H:i a') }}</h5>
{{--                            <h5 class="card-title text-center text-primary">إجمالي الطلب : {{ $total.' '.env('APP_CURRENCY') }}</h5>--}}
                            <div class="text-center">
                                <a class="btn btn-primary text-center">إجمالي الطلب : {{ $total.' '.env('APP_CURRENCY') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
