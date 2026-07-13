@extends('layouts.guest')

@section('content')
    <div class="book-area py-5 bg-white box-shadow">
        <div class="container">
            <div class="book-content text-center">
                <h2>{{ translate(29) }}</h2>
                <p>{{ translate(591) }}</p>
                <a class="btn mt-4 btn-dark" href="{{ routeWithLocale('guest.register') }}">
                    {{ translate(134) }}
                </a>
            </div>
        </div>
    </div>

    <!--fun-fact-area start-->
    <div class="fun-fact-area bg-theme">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center">
                    <div class="section-title section-title-2">
                        <h6 class="subtitle subtitle-thumb">{{ translate(584) }}</h6>
                        <h2 class="title">{{ translate(285) }}</h2>
                        <p>{{ translate(286) }}</p>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-4 col-sm-6 text-center">
                    <div class="single-fact">
                        <h1 class="counter">76923</h1>
                        <p>{{ translate(581) }}</p>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6 text-center">
                    <div class="single-fact">
                        <h1 class="counter">9250</h1>
                        <p>{{ translate(582) }}</p>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6 text-center">
                    <div class="single-fact">
                        <h1 class="counter">18243</h1>
                        <p>{{ translate(583) }}</p>
                    </div>
                </div>
                <div class="col-lg-12 text-center">
                    <a class="btn btn-light" href="{{ routeWithLocale('guest.login') }}">{{ translate(585) }}</a>
                </div>
            </div>
        </div>
    </div>
    <!--fun-fact-area end-->

    @if ( $testimonials->count() )
        <x-guest-testimonials :items=$testimonials pagination='false' />
    @endif

@endsection