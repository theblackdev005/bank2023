@extends('layouts.guest')

@section('content')
    <div class="book-area py-5 bg-white box-shadow">
        <div class="container">
            <div class="book-content text-center">
                <h2>{{ translate(29) }}</h2>
                <p>{{ translate(591) }}</p>
                <a class="btn mt-4 btn-primary" href="{{ routeWithLocale('guest.register') }}">
                    {{ translate(134) }}
                </a>
            </div>
        </div>
    </div>

    <!--fun-fact-area start-->
    <div class="bg-light pb-5">
        <div class="container">

            <div id="s1" class="row py-5">
                <div class="col-lg-4 pb-4">
                    <div class="styl-card p-4 bg-white">
                        <img src="{{ asset_img('cards/basic.svg') }}" alt="">
                        <h5 class="text-theme mt-2">{{ translate(164) }}</h5>
                        <p class="mb-3">{{ translate(228) }}</p>
                        <div>
                            <a href="{{ routeWithLocale('guest.register') }}" class="btn btn-dark">{{ translate(134) }}</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 pb-4">
                    <div class="styl-card bg-white p-4">
                        <img src="{{ asset_img('cards/standard.svg') }}" alt="">
                        <h5 class="mt-2">{{ translate(165) }}</h5>
                        <p class="mb-3">{{ translate(230) }}</p>
                        <div>
                            <a href="{{ routeWithLocale('guest.register') }}" class="btn btn-dark">{{ translate(134) }}</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 pb-4">
                    <div class="styl-card p-4 bg-white">
                        <img src="{{ asset_img('cards/premium.svg') }}" alt="">
                        <h5 class="text-theme mt-2">{{ translate(166) }}</h5>
                        <p class="mb-3">{{ translate(232) }}</p>
                        <div>
                            <a href="{{ routeWithLocale('guest.register') }}" class="btn btn-dark">{{ translate(134) }}</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!--fun-fact-area end-->
@endsection