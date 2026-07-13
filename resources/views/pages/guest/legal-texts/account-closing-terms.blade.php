@extends('layouts.guest')

@php
    \App\TranslationHelper::setActiveFolder('account-closing-terms');
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
                        <h5>1. {{ translate(2) }}</h5>
                        <ul>
                            <li class="text-muted">{{ translate(3) }}</li>
                            <li class="text-muted">{{ translate(4) }}</li>
                            <li class="text-muted">{{ translate(5) }}</li>
                            <li class="text-muted">{{ translate(6) }}</li>
                            <li class="text-muted">{{ translate(7) }}</li>
                        </ul>
                        <h5 class="mt-4">2. {{ translate(8) }}</h5>
                        <ul>
                            <li class="text-muted">{{ translate(9) }}</li>
                            <li class="text-muted">{{ translate(10) }}</li>
                            <li class="text-muted">{{ translate(11) }}</li>
                            <li class="text-muted">{{ translate(12) }}</li>
                            <li class="text-muted">{{ translate(13) }}</li>
                        </ul>
                        <h5 class="mt-4">3. {{ translate(14) }}</h5>
                        <ul>
                            <li class="text-muted">{!! translate(15) !!}</li>
                        </ul>
                        <h5 class="mt-4">4. {{ translate(16) }}</h5>
                        <ul>
                            <li class="text-muted">{{ translate(17) }}</li>
                        </ul>
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