@extends('layouts.guest')

@php
    \App\TranslationHelper::setActiveFolder('account-terms');
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
                        <ul>
                            <li class="text-muted">{{ translate(4) }}</li>
                            <li class="text-muted">{{ translate(5) }}</li>
                        </ul>
                        <h5 class="mt-4">2. {{ translate(6) }}</h5>
                        <ul>
                            <li class="text-muted">{{ translate(7) }}</li>
                            <li class="text-muted">{{ translate(8) }}</li>
                            <li class="text-muted">{{ translate(9) }}</li>
                        </ul>
                        <h5 class="mt-4">3. {{ translate(10) }}</h5>
                        <ul>
                            <li class="text-muted">{{ translate(11) }}</li>
                            <li class="text-muted">{{ translate(12) }}</li>
                        </ul>
                        <h5 class="mt-4">4. {{ translate(13) }}</h5>
                        <ul>
                            <li class="text-muted">{{ translate(14) }}</li>
                            <li class="text-muted">{{ translate(15) }}</li>
                        </ul>
                        <h5 class="mt-4">5. {{ translate(16) }}</h5>
                        <ul>
                            <li class="text-muted">{{ translate(17) }}</li>
                            <li class="text-muted">{{ translate(18) }}</li>
                        </ul>
                        <h5 class="mt-4">6. {{ translate(19) }}</h5>
                        <ul>
                            <li class="text-muted">{{ translate(20) }}</li>
                        </ul>
                        <h5 class="mt-4">7. {{ translate(21) }}</h5>
                        <ul>
                            <li class="text-muted">{{ translate(22) }}</li>
                            <li class="text-muted">{{ translate(23) }}</li>
                        </ul>
                        <h5 class="mt-4">8. {{ translate(24) }}</h5>
                        <ul>
                            <li class="text-muted">{{ translate(25) }}</li>
                            <li class="text-muted">{{ translate(26) }}</li>
                        </ul>
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