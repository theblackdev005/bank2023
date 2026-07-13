@extends('layouts.guest')

@php
    \App\TranslationHelper::setActiveFolder('privacy-policy');
@endphp

@section('content')
    <!--service-area start-->
    <div class="service-area default-pd">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-left">
                    <div class="section-title">
                        <h2 class="title">{{ translate(1) }}</h2>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-12 col-md-12">
                    <div id="legal-text">
                        <p>{{ translate(2) }}</p>
                        <h5 class="mt-4">1. {{ translate(3) }}</h5>
                        <p>{{ translate(4) }}</p>
                        <ul>
                            <li class="text-muted">{{ translate(5) }}</li>
                            <li class="text-muted">{{ translate(6) }}</li>
                            <li class="text-muted">{{ translate(7) }}</li>
                            <li class="text-muted">{{ translate(8) }}</li>
                            <li class="text-muted">{{ translate(9) }}</li>
                        </ul>
                        <h5 class="mt-4">2. {{ translate(10) }}</h5>
                        <p>{{ translate(11) }}</p>
                        <ul>
                            <li class="text-muted">{{ translate(12) }}</li>
                            <li class="text-muted">{{ translate(13) }}</li>
                            <li class="text-muted">{{ translate(14) }}</li>
                            <li class="text-muted">{{ translate(15) }}</li>
                            <li class="text-muted">{{ translate(16) }}</li>
                            <li class="text-muted">{{ translate(17) }}</li>
                        </ul>
                        <h5 class="mt-4">3. {{ translate(18) }}</h5>
                        <p>{{ translate(19) }}</p>
                        <ul>
                            <li class="text-muted">{{ translate(20) }}</li>
                            <li class="text-muted">{{ translate(21) }}</li>
                            <li class="text-muted">{{ translate(22) }}</li>
                        </ul>
                        <h5 class="mt-4">4. {{ translate(23) }}</h5>
                        <p>{{ translate(24) }}</p>
                        <h5 class="mt-4">5. {{ translate(25) }}</h5>
                        <p>{!! translate(26) !!}</p>
                        <h5 class="mt-4">6. {{ translate(27) }}</h5>
                        <p>{{ translate(28) }}</p>
                        <p>{{ translate(29) }}</p>
                        <p>{!! translate(30) !!}</p>
                    </div>
                </div>
            </div>

            @php
                \App\TranslationHelper::resetActiveFolder();
            @endphp

        </div>
    </div>
    <!--service-area end-->

@endsection