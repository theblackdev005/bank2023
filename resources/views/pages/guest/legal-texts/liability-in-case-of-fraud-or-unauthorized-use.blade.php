@extends('layouts.guest')

@php
    \App\TranslationHelper::setActiveFolder('liability-in-case-of-fraud-or-unauthorized-use');
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
                        <h5 class="mt-4">{{ translate(3) }}</h5>
                        <p>{{ translate(4) }}</p>
                        <h5 class="mt-4">{{ translate(5) }}</h5>
                        <p>{{ translate(6) }}</p>
                        <h5 class="mt-4">{{ translate(7) }}</h5>
                        <p>{{ translate(8) }}</p>
                        <h5 class="mt-4">{{ translate(9) }}</h5>
                        <p>{{ translate(10) }}</p>
                        <h5 class="mt-4">{{ translate(11) }}</h5>
                        <p>{{ translate(12) }}</p>
                        <h5 class="mt-4">{{ translate(13) }}</h5>
                        <p>{{ translate(14) }}</p>
                        <h5 class="mt-4">{{ translate(15) }}</h5>
                        <p>{{ translate(16) }}</p>
                        <p>{{ translate(17) }}</p>
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