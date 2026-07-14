@extends('layouts.guest')

@section('content')
	<!-- banner start -->
	<div class="banner-area style-two" id="owl-slides">
		<div class="banner-slider owl-carousel">

			@foreach ($slides as $slide)
				<div class="item single-owl-item bg-theme-light bg-with-covered-image" style="background-image: url('{{ asset_img($slide['image']) }}');">
					<div class="container single-owl-item-box">
						<div class="row single-owl-item-box">
							<div class="col-xl-7 col-lg-7">
								<div class="banner-inner-area px-0">
									<h1 class="title text-dark">{{ translate($slide['title']) }}</h1>
									<p class="text-muted">{{ translate($slide['text']) }}</p>
									<div class="d-flex flex-wrap align-items-center">
										<a class="btn btn-radius btn-theme mr-2 mb-2" href="{{ routeWithLocale('guest.login') }}">{{ translate(132) }}</a>
										<a class="btn btn-radius btn-dark mb-2" href="{{ routeWithLocale('guest.register') }}">{{ translate(134) }}</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			@endforeach
			
		</div>
	</div>
	<!-- banner end -->

	<!-- money-option start -->
	<div class="money-option-area cst__0money-option-area">
		<div class="container our-partners-row-container">
			<div class="row d-flex">
				<div class="col-12 bg-light box-shadow rounded position-relative">
					<div class="row d-flex flex-wrap-reverse py-2 px-2">
						<div class="col-lg-5 d-flex justify-content-between align-items-start bg-white py-4">
							<div class="row bg-white px-4 flex-wrap rounded">
								@foreach (partners() as $partner)
									<div class="col-6 col-md-6 d-block py-2">
										<img src="{{ asset_img( 'partners/' . $partner ) }}" alt="" style="height: 50px;">
									</div>
								@endforeach
							</div>
						</div>
						<div class="col-lg-7 d-flex">
							<div class="partners-section-horizontal-title-block px-4">
								<h4 class="title pm-0 font-weight-bold">{{ translate(172) }}</h4>
								<p class="text-wite">{{ translate(762) }}</p>
								<a href="{{ routeWithLocale('guest.register') }}" class="btn btn-theme">{{ translate(281) }}</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="py-3 d-lg-none d-xl-none"></div>

		<div class="container our-solutions-row-container">
			<div class="text-center">
				<h2 class="font-weight-bold">{{ translate(29) }}</h2>
				<p>{{ translate(571) }}</p>
			</div>
			<div class="row d-flex flex-wrap top__solutions_wrap">

				@foreach ($solutions as $link => $solution)
					<div class="col-12 col-lg-6 p-2 mb-2 col-md-6 d-flex">
						<div class="our-solutions-container hover-bg-white border-bottom rounded bg-light py-4 px-3 mt-0 d-flex flex-wrap flex-lg-nowrap flex-xl-nowrap justify-content-center align-items-center">
							<div class="our-solutions-left-icon-box mb-2 bg-theme-light rounded-circle d-flex justify-content-center align-items-center bg-theme-light">
								<i class="material-symbols-outlined base text-{{ $solution['theme'] }}">{{ $solution['icon'] }}</i>
							</div>
							<div class="our-solutions-text-box px-4 text-center text-lg-left text-xl-left">
								<h5 class="mb-2"><a href="{{ routeWithLocale($link) }}">{{ translate($solution['title']) }}</a></h5>
								<p class="text-muted fz-16">{{ translate($solution['text']) }}</p>
							</div>
							<div class="our-solutions-link-box mt-2">
								<a class="bg-theme-light d-flex justify-content-center align-items-center p-2" href="{{ routeWithLocale($link) }}">
									<i class="material-symbols-outlined text-theme">chevron_right</i>
								</a>
							</div>
						</div>
					</div>
				@endforeach
			</div>
		</div>
	</div>
	<!-- money-option end -->

	{{-- Temoignages --}}
	@if ( $testimonials->count() )
		<x-guest-testimonials :items=$testimonials pagination="false" />
	@endif
	{{-- Temoignages --}}

	<section class="two-partite shadow-none">
		<div class="container-fluid">
			<div class="row">
				<div class="col-lg-7 bg-theme" style="position: relative;">
					{{-- <img src="{{ asset_img('shape-1.png') }}" class="image-as-overlay"> --}}
					<div class="book-content py-100 px-4 text-left">
						<h6 class="subtitle subtitle-thumb">{{ translate(584) }}</h6>
						<h2 class="title font-weight-bold">{{ translate(285) }}</h2>
						<p>{{ translate(830) }}</p>
						<div class="pt-5">
							<a class="btn btn-light" href="{{ routeWithLocale('guest.login') }}">{{ translate(585) }}</a>
						</div>
					</div>
				</div>
				<div class="col-lg-5 bg-with-covered-image" style="background-image: url({{ asset_img('security-1.jpg') }});"></div>
			</div>
		</div>
	</section>

	<!--service-area start-->
	<div class="service-area py-5 bg-white">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-lg-8 text-center">
					<div class="section-title">
						<h2 class="title">{{ translate(586) }}</h2>
					</div>
				</div>
			</div>
			<div class="row justify-content-center">
				<div class="col-lg-4 col-md-6 mb-3 d-flex">
					<div class="d-flex flex-column rounded">
						<div class="thumb pb-3">
							<img src="{{ asset_img('default/service/service__1.jpg') }}" alt="">
						</div>
						<div class="service-details">
							<h5 class="text- font-weight-bold"><a href="javascript:;">{{ translate(309) }}</a></h5>
							<p class="text-muted">{{ translate(310) }}</p>
						</div>
					</div>
				</div>
				<div class="col-lg-4 col-md-6 mb-3 d-flex">
					<div class="d-flex flex-column rounded">
						<div class="thumb pb-3">
							<img src="{{ asset_img('default/service/service__2.jpg') }}" alt="">
						</div>
						<div class="service-details">
							<h5 class="text- font-weight-bold"><a href="{{ routeWithLocale('guest.contact') }}">{{ translate(305) }}</a></h5>
							<p class="text-muted">{{ translate(306) }}</p>
						</div>
					</div>
				</div>
				<div class="col-lg-4 col-md-6 mb-3 d-flex">
					<div class="d-flex flex-column rounded">
						<div class="thumb pb-3">
							<img src="{{ asset_img('default/service/service__3.jpg') }}" alt="">
						</div>
						<div class="service-details">
							<h5 class="font-weight-bold"><a href="{{ routeWithLocale('guest.loans') }}">{{ translate(313) }}</a></h5>
							<p class="text-muted">{{ translate(314) }}</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<section class="two-partite shadow-none">
		<div class="container-fluid">
			<div class="row">
				<div class="col-lg-5 bg-with-covered-image" style="background-image: url({{ asset_img('about-cards.jpg') }});"></div>
				<div class="col-lg-7 bg-dark" style="position: relative;">
					<img src="{{ asset_img('shape-1.png') }}" class="image-as-overlay">
					<div class="book-content py-100 px-4 text-left">
						<h2 class="title font-weight-bold text-white mb-4">{{ translate(311) }}</h2>
						<p class="text-white mb-3">{{ translate(312) }}</p>
						<div>
							@foreach ([164, 165, 166] as $card)
								<p class="d-flex align-items-center mb-0">
									<i class="material-symbols-outlined text-theme">task_alt</i>
									<span class="ml-2 text-white">{{ translate($card) }}</span>
								</p>
							@endforeach
						</div>
						<div class="pt-5">
							<a class="btn btn-theme hover-bg-white hover-color-theme" href="{{ routeWithLocale('guest.login') }}">{{ translate(585) }}</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!--service-area end-->

	<!--fun-fact-area start-->
	<div class="fun-fact-area" style="background: white !important;">
		<div class="container">
			<div class="row">
				<div class="col-lg-10 mx-auto text-center" style="position: relative;">
					<div class="section-title mb-3 section-title-2">
						<h2 class="title text-dark">{{ translate(307) }}</h2>
						<p class="text-dark">{{ translate(308) }}</p>
					</div>
				</div>
				<div class="col-lg-12">
					<div class="row justify-content-left">

						@php
							$index = 1;
						@endphp

						@foreach (loans() as $uri => $loan)
							@break($index > 3)

							<div class="col-lg-4">
								<div class="loan-box-inner">
									<div class="loan-box-inner-image mb-3">
										<img src="{{ asset_img('loans/'. $uri .'.png') }}" alt="">
									</div>
									<div class="py-2">
										<h5 class="m-0 text-dark font-weight-bold mb-2">{{ translate($loan[0]) }}</h5>
										<p class="text-muted">{{ translate($loan[1], 150) }}</p>
									</div>
								</div>
							</div>

							@php
								$index++
							@endphp
						@endforeach
					</div>
				</div>
				<div class="col-12">
					<div class="mt-3 text-center">
						<a class="btn btn-primary" href="{{ routeWithLocale('guest.loan_request') }}">{{ translate(339) }}</a>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!--fun-fact-area end-->

	@if ( SITE_ADDRESS )
		<section>
			<div class="container-fluid">
				<div class="row">
					<x-google-maps />
				</div>
			</div>
		</section>
	@endif
@endsection
