@extends('layouts.auth_admin_app')

@section('title', 'Show Single Product')

@section('content')


    <div class="container">
        <div class="page-holder bg-light">
            <section class="py-5">
                <div class="container">
                    <div class="row mb-5">
                        <!-- PRODUCT DETAILS-->
                        <div class="col-lg-6" style="direction: rtl;">
                            <h1>{{ $product->name_ar }}</h1>
                            @php $rating = $product->avgRatings() @endphp
                            @foreach(range(1,5) as $i)
                                <span class="fa-stack" style="width:1.5em;">
                                    <i class="far fa-star fa-stack-1x text-warning lazy"></i>
                                    @if($rating >0)
                                        @if($rating >0.5)
                                            <i class="fas fa-star fa-stack-1x text-warning lazy"></i>
                                        @else
                                            <i class="fas fa-star-half fa-flip-horizontal text-warning lazy"></i>
                                        @endif
                                    @endif
                                    @php $rating--; @endphp
                                </span>
                            @endforeach

                            <p class="text-muted lead">{{ env('APP_CURRENCY').' '.$product->price }}</p>
                            <p class="text-small mb-4">{{ $product->description_ar }}</p>
                            <ul class="list-unstyled small d-inline-block" style="font-size: medium">
                                <li class="px-3 py-2 mb-1 bg-white"><strong class="text-uppercase">الكمية الموجودة بالمخازن : </strong><span class="ml-2 text-muted">{{ $product->stock }}</span></li>
                                <li class="px-3 py-2 mb-1 bg-white"><strong class="text-uppercase">كمية البيع للعنصر : </strong><span class="ml-2 text-muted">{{ $product->quantity.' '.$product->unit->name_ar }}</span></li>
                                <li class="px-3 py-2 mb-1 bg-white"><strong class="text-uppercase">القسم : </strong><span class="ml-2 text-muted">{{ $product->category->name_ar }}</span></li>
                                <li class="px-3 py-2 mb-1 bg-white"><strong class="text-uppercase">الحالة : </strong><span class="ml-2 text-muted">{{ $product->status != '1'? 'غير نشط' : 'نشط' }}</span></li>
                                <li class="px-3 py-2 mb-1 bg-white"><strong class="text-uppercase">مميز : </strong><span class="ml-2 text-muted">{{ $product->feature != '1'? 'عادي' : 'مميز' }}</span></li>
                            </ul>
                        </div>
                        <div class="col-lg-6">
                            <!-- PRODUCT SLIDER-->
                            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                                <ol class="carousel-indicators">
                                    @foreach ($product->media as $media)
                                        <li data-target="#carouselExampleIndicators" data-slide-to="{{ $loop->index }}"
                                            class="{{ $loop->first ? 'active' : '' }}"></li>
                                    @endforeach
                                </ol>
                                <div class="carousel-inner">
                                    @foreach ($product->media as $media)
                                        <div class="carousel-item {{ $loop->first ? 'active' : '' }}" style="margin-left:0px !important; float: left!important;">
                                            <img class="d-block w-100" src="{{ asset($media->file_name) }}" alt="First slide">
                                        </div>
                                    @endforeach
                                </div>
                                <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Previous</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <!-- DETAILS TABS-->
                    <ul class="nav nav-tabs border-0" id="myTab" role="tablist">
                        <li class="nav-item" style="font-size: larger">
                            <a class="nav-link active" id="name-tab" data-toggle="tab" href="#name" role="tab" aria-controls="name" aria-selected="true">الأسم</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="description-tab" data-toggle="tab" href="#description" role="tab" aria-controls="description" aria-selected="true">الوصف</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="units-tab" data-toggle="tab" href="#units" role="tab" aria-controls="units" aria-selected="false">أوزان المنتج</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="reviews-tab" data-toggle="tab" href="#reviews" role="tab" aria-controls="reviews" aria-selected="false">احدث التعليقات</a>
                        </li>
                    </ul>
                    <div class="tab-content mb-5" id="myTabContent">
                        <div class="tab-pane fade show active" id="name" role="tabpanel" aria-labelledby="name-tab">
                            <div class="p-4 p-lg-5 bg-white">
                                <h6 class="text-uppercase">الأسم (الانجليزية)</h6>
                                <p class="text-muted text-small mb-0">{{ $product->name_en }}</p>
                            </div>
                            <hr style="border: unset;margin-bottom: 0px!important;margin-top: 5px!important;">
                            <div class="p-4 p-lg-5 bg-white">
                                <h6 class="text-uppercase">الأسم (أوردو)</h6>
                                <p class="text-muted text-small mb-0">{{ $product->name_ur }}</p>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="description" role="tabpanel" aria-labelledby="description-tab">
                            <div class="p-4 p-lg-5 bg-white">
                                <h6 class="text-uppercase">الوصف (الانجليزية)</h6>
                                <p class="text-muted text-small mb-0">{{ $product->description_en }}</p>
                            </div>
                            <hr style="border: unset;margin-bottom: 0px!important;margin-top: 5px!important;">
                            <div class="p-4 p-lg-5 bg-white">
                                <h6 class="text-uppercase">الوصف (أوردو)</h6>
                                <p class="text-muted text-small mb-0">{{ $product->description_ur }}</p>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="units" role="tabpanel" aria-labelledby="units-tab">
                            <div class="p-4 p-lg-5 bg-white">
                                <div class="row">
                                    <div class="col-lg-8">
                                        <table class="table">
                                            <caption>عدد الأوزان = {{ $product->units()->count() }}</caption>
                                            <thead>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>الوزن</td>
                                                    <td>السعر</td>
                                                    <td>الحالة</td>
                                                </tr>
                                                @foreach($product->units as $unit)
                                                    <tr>
                                                        <td>{{ $unit->unit->name_ar }}</td>
                                                        <td>{{ $unit->price }}</td>
                                                        <td>{{ $unit->status == 1 ? 'نشط' : 'غير نشط' }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
                            <div class="p-4 p-lg-5 bg-white">
                                <div class="row">
                                    <div class="col-lg-8">
                                        @foreach($product->reviews as $review)
                                            @php  $user = \App\Models\User::whereId($review->user_id)->first(); @endphp
                                            <div class="media mb-3"><img class="rounded-circle" src="{{ asset($user->image) }}" alt="" width="50">
                                                <div class="media-body ml-3">
                                                    <h6 class="mb-0 text-uppercase">{{ $user->full_name }}</h6>
                                                    <p class="small text-muted mb-0 text-uppercase">{{ \Carbon\Carbon::parse($review->created_at)->translatedFormat('l j F Y H:i a') }}</p>
                                                    @php $rating = $review->rating @endphp
                                                    @foreach(range(1,5) as $i)
                                                        <span class="fa-stack" style="width:1.5em;">
                                                        <i class="far fa-star fa-stack-1x text-warning lazy"></i>
                                                        @if($rating >0)
                                                                <i class="fas fa-star fa-stack-1x text-warning lazy"></i>
                                                        @endif
                                                        @php $rating--; @endphp
                                                        </span>
                                                    @endforeach
                                                    <p class="text-small mb-0 text-muted">{{ $review->content }}</p>
                                                </div>
                                            </div>
                                            <hr style="margin-bottom: 10px!important;margin-top: 10px!important;">
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- RELATED PRODUCTS-->
                </div>
            </section>
        </div>
    </div>

@endsection
@section('script')
    <script>
        // ------------------------------------------------------- //
        //   Inject SVG Sprite -
        //   see more here
        //   https://css-tricks.com/ajaxing-svg-sprite/
        // ------------------------------------------------------ //
        function injectSvgSprite(path) {

            var ajax = new XMLHttpRequest();
            ajax.open("GET", path, true);
            ajax.send();
            ajax.onload = function(e) {
                var div = document.createElement("div");
                div.className = 'd-none';
                div.innerHTML = ajax.responseText;
                document.body.insertBefore(div, document.body.childNodes[0]);
            }
        }
        // this is set to BootstrapTemple website as you cannot
        // inject local SVG sprite (using only 'icons/orion-svg-sprite.svg' path)
        // while using file:// protocol
        // pls don't forget to change to your domain :)
        injectSvgSprite('https://bootstraptemple.com/files/icons/orion-svg-sprite.svg');

    </script>
    <!-- FontAwesome CSS - loading as last, so it doesn't block rendering-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

@endsection
