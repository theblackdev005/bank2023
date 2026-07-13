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
                \App\TranslationHelper::setActiveFolder('legal-notice');
            @endphp

            <div class="row justify-content-center">
                <div class="col-lg-12 col-md-12">
                    <div id="legal-text">
                        <p>{{ translate(2) }}</p>
                        <p class="pt-3">
                            <span>{{ translate(3) }}</span><br>
                            <span>{{ translate(4) }}</span><br>
                            <span>{{ translate(5) }}</span><br>
                            <span>{!! translate(6) !!}</span><br>
                            <span>{{ translate(7) }}</span><br>
                        </p>
                        <h5 class="mt-4">1. {{ translate(8) }}</h5>
                        <p>{{ translate(9) }}</p>
                        <h5 class="mt-4">2. {{ translate(10) }}</h5>
                        <p>{{ translate(11) }}</p>
                        <h5 class="mt-4">3. {{ translate(12) }}</h5>
                        <p>{{ translate(13) }}</p>
                        <h5 class="mt-4">4. {{ translate(14) }}</h5>
                        <p>{{ translate(15) }}</p>
                        <h5 class="mt-4">5. {{ translate(16) }}</h5>
                        <p>{{ translate(17) }}</p>
                        <p>{{ translate(18) }}</p>
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