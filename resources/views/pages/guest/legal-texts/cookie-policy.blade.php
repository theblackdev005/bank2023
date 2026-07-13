@extends('layouts.guest')

@section('content')
    <!--service-area start-->
    <div class="service-area default-pd">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 text-left">
                    <div class="section-title">
                        <h2 class="title">{{ page_name() }}</h2>
                    </div>
                </div>
            </div>

            @php
                \App\TranslationHelper::setActiveFolder('cookie-policy');
            @endphp

            <div class="row justify-content-center">
                <div class="col-lg-12 col-md-12">
                    <div id="legal-text">
                        <p>{{ translate(1) }}</p>
                        <h5 class="mt-4">1. {{ translate(2) }}</h5>
                        <p>{{ translate(3) }}</p>
                        <h5 class="mt-4">2. {{ translate(4) }}</h5>
                        <p>{{ translate(5) }}</p>
                        <h5 class="mt-4">3. {{ translate(6) }}</h5>
                        <p>{{ translate(7) }}</p>
                        <p>{{ translate(8) }}</p>
                        <h5 class="mt-4">4. {{ translate(9) }}</h5>
                        <p>{{ translate(10) }}</p>
                        <h5 class="mt-4">5. {{ translate(11) }}</h5>
                        <p>{{ translate(12) }}</p>
                        <h5 class="mt-4">6. {{ translate(13) }}</h5>
                        <p>{{ translate(14) }}</p>
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