@extends('layouts.guest')

@section('content')
    <!--service-area start-->
    <div class="service-area default-pd">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-left">
                    <div class="section-title">
                        <h2 class="title">{{ translate(918) }}</h2>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-12 col-md-12">
                    <div id="legal-text">
                        
                        <p>{{ translate(904) }}</p>

                        <h2 class="mt-4">{{ translate(193) }}</h2>
                        <p>{{ translate(905) }}</p>
                        <ul>
                            <li>{{ translate(906) }}</li>
                            <li>{{ translate(907) }}</li>
                            <li>{{ translate(908) }}</li>
                        </ul>

                        <h2 class="mt-4">{{ translate(194) }}</h2>
                        <p>{{ translate(909) }}</p>
                        <ul>
                            <li>{{ translate(910) }}</li>
                            <li>{{ translate(911) }}</li>
                            <li>{{ translate(912) }}</li>
                        </ul>

                        <h2 class="mt-4">{{ translate(195) }}</h2>
                        <p>{{ translate(913) }}</p>
                        <ul>
                            <li>{{ translate(914) }}</li>
                            <li>{{ translate(915) }}</li>
                            <li>{{ translate(916) }}</li>
                        </ul>

                    </div>
                </div>
            </div>

        </div>
    </div>
    <!--service-area end-->

@endsection