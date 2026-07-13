@extends('layouts.guest')

@section('content')
	<div class="book-area py-5 bg-theme-light">
	    <div class="container">
	        <div class="book-content text-center">
	            <h2>{{ translate(120) }}</h2>
	            <p>{{ translate(589) }}</p>
	            <a class="btn mt-4 btn-dark" href="{{ routeWithLocale('guest.loan_request') }}">
	                {{ translate(592) }}
	            </a>
	        </div>
	    </div>
	</div>

	<section class="py-5 bg-light shadow-none">
		<div class="container">
			<div class="row">
				<div class="col-lg-7 mb-4">
					<div class="bg-white rounded p-3">
						<div class="w-100">
							<img src="{{ asset_img('loans/'. $uri .'.png') }}" alt="" class="img-fluid border rounded mb-3 w-100">
						</div>
						
						<div class="py-3">
							<a href="#" class="mt-4 h2 text-dark">{{ translate($data[0]) }}</a>
							<p class="text-muted mt-2">{{ translate($data[1]) }}</p>
						</div>

					</div>
				</div>
				<div class="col-lg-5 ">
					<ul class="list-unstyled">

						@foreach ($data_service as $_uri => $value)
							<li class="row {{ ($_uri == $uri) ? 'bg-light' : 'bg-white' }} mb-2 box-shado py-3 rounded">
								<a href="{{ routeWithLocale('guest.loans', $_uri) }}" class="col-3">
									<img src="{{ asset_img('loans/'. $_uri .'.png') }}" alt="" class="img-fluid rounded">
								</a>
								<div class="col-9">
									<a href="{{ routeWithLocale('guest.loans', $_uri) }}">
										<h6 class="mb-1 h5 text-dark">{{ translate($value[0]) }}</h6>
									</a>
									<div class="d-flex text-small">
										<span class="text-muted">{{ translate($value[1], 100) }}</span>
									</div>
								</div>
							</li>
						@endforeach

					</ul>
				</div>
			</div>
		</div>
	</section>

	<div class="service-area py-5">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-lg-8 text-center">
					<div class="section-title">
						<h2 class="title">{{ translate(631) }}</h2>
					</div>
				</div>
			</div>
			<div class="row justify-content-center">
				<div class="col-lg-4 col-md-6">
					<div class="bg-light rounded p-4 shadow-sm mb-2">
						<div class="service-details">
							<h5 class="font-weight-bold mb-3"><a href="{{ routeWithLocale('guest.loan_request') }}">{{ translate(357) }}</a></h5>
							<p class="text-muted">{{ translate(358) }}</p>
						</div>
					</div>
				</div>
				<div class="col-lg-4 col-md-6">
					<div class="bg-theme rounded p-4 shadow-sm mb-2">
						<div class="service-details">
							<h5 class="font-weight-bold mb-3 text-white"><a href="{{ routeWithLocale('guest.loan_request') }}">{{ translate(359) }}</a></h5>
							<p class="text-white">{{ translate(360) }}</p>
						</div>
					</div>
				</div>
				<div class="col-lg-4 col-md-6">
					<div class="bg-light rounded p-4 shadow-sm mb-2">
						<div class="service-details">
							<h5 class="font-weight-bold mb-3"><a href="{{ routeWithLocale('guest.loan_request') }}">{{ translate(361) }}</a></h5>
							<p class="text-muted">{{ translate(362) }}</p>
						</div>
					</div>
				</div>

			</div>
		</div>
	</div>
	<!--service-area end-->

	<!-- apply_loan_start  -->
	<div class="apply_loan">
		<div class="overlay"></div>
		<div class="container">
			<div class="row align-items-center justify-content-center">
				<div class="col-lg-8 col-md-10">
					<div class="loan_text wow fadeInLeft text-lg-left text-center" data-wow-duration="1s" data-wow-delay=".3s">
						<h3>{{ translate(588) }}</h3>
					</div>
				</div>
				<div class="col-lg-4">
					<div class="loan_btn text-lg-right text-center wow fadeInUp" data-wow-duration="1.2s" data-wow-delay=".4s">
						<a class="btn btn-blue" href="{{ routeWithLocale('guest.register') }}">{{ translate(134) }} <i class="fa fa-chevron-right"></i></a>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- apply_loan_end  -->
@endsection