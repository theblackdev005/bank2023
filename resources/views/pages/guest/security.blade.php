@extends('layouts.guest')

@section('content')
    <!--about-us-area start-->
    <div class="about-us-area pd-100">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-5 col-md-8 align-self-center">
                    <div class="about-us-video">
                        <img class="thumb" src="{{ asset_img('default/video/1.png') }}" alt="img">
                    </div>
                </div>
                <div class="col-lg-6 offset-lg-1">
                    <div class="about-us-details">
                        <div class="section-title">
                            <h6 class="subtitle">{{ page_name() }}</h6>
                            <h2 class="title">{{ translate(530) }}</h2>
                            <p>{{ translate(531) }}</p>
                        </div>
                        
                        <div class="section-title">
                            <h2 class="title">{{ translate(536) }}</h2>
                            <p>{{ translate(532) }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--about-us-area end-->

    <!--service-area start-->
    <div class="service-area py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center">
                    <div class="section-title">
                        <h2 class="title text-theme">{{ translate(527) }}</h2>

                        <p>{{ translate(533) }} {!! translate(534) !!}</p>
                        <div>
                            <a href="mailto:{{ SITE_EMAIL }}" class="btn btn-primary"><i class="fa far fas fa-envelope"></i> {{ translate(31) }}</a>
                            <a href="tel:{{ SITE_PHONE }}" class="btn btn-dark"><i class="fa far fas fa-phone"></i> {{ translate(380) }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--service-area end-->
@endsection