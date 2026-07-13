<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" ng-app="bankingNgApp">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<title>{{ site_title() }}</title>

	@if ( ! GOOGLE_INDEXED )
		<meta name="robots" content="not follow"/>
	@endif

	{!! social_meta_tags(145) !!}
	{!! goTranslateScripts() !!}
	
	<link rel="shortcut icon" type="image/x-icon" href="{{ site_favicon() }}">
	<link rel="stylesheet" type="text/css" href="{{ asset_css('google-translate.css') }}">

	{{-- Stylesheet --}}
	<link rel="stylesheet" type="text/css" href="{{ asset_css('default/vendor.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset_css('default/style.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset_css('default/responsive.css') }}">

	<link rel="stylesheet" type="text/css" href="{{ asset_css('default/custom.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset_css('default/multi-step-form.css') }}">
	
	{{-- intl --}}
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css" />
	<link rel="stylesheet" type="text/css" href="{{ asset_css('common.css') }}">

	@if ( !empty(GOOGLE_TAG_MANAGER_ID) )
		<!-- Google tag (gtag.js) -->
		<script async src="https://www.googletagmanager.com/gtag/js?id={{ GOOGLE_TAG_MANAGER_ID }}"></script>
		<script>
			window.dataLayer = window.dataLayer || [];
			function gtag(){dataLayer.push(arguments);}
			gtag('js', new Date());

			gtag('config', '{{ GOOGLE_TAG_MANAGER_ID }}');
		</script>
		<!--// Google tag (gtag.js) -->
	@endif

	@yield('style')
	@livewireStyles
</head>
<body class="bg-two">

	<!-- preloader area start -->
	<div class="preloader" id="preloader">
		<div class="preloader-inner">
			<div class="spinner">
				<div class="dot1"></div>
				<div class="dot2"></div>
			</div>
		</div>
	</div>
	<!-- preloader area end -->
	<div class="body-overlay" id="body-overlay"></div>

	<!-- topbar-area start -->
	<div class="topbar-area bg-light">
		<div class="container">
			<div class="row">
				<div class="col-md-6 align-self-center">
					<div class="topbar-left text-md-left text-center">
						<p class="text-muted"><i class="fa text-theme fa-map-marker"></i>{{ SITE_ADDRESS }}</p>
					</div>
				</div>
				<div class="col-md-6 text-md-right text-center">
					<div class="topbar-right">

						@if ( SHOW_PHONENUMBER_ON_HOMEPAGE )
							@if ( SITE_WHATSAPP )
								<p class="text-small text-muted"><i class="fa text-theme fa-whatsapp"></i> <a href="{{ whatsapp_link() }}">{{ SITE_WHATSAPP }}</a></p>
							@else
								<p class="text-small text-muted"><i class="fa text-theme fa-phone"></i> <a href="tel:{{ SITE_PHONE }}">{{ SITE_PHONE }}</a></p>
							@endif
						@endif

						<p class="text-small text-muted"><i class="fa text-theme fa-envelope"></i> <a href="mailto:{{ SITE_EMAIL }}">{{ SITE_EMAIL }}</a></p>
						<p class="text-small text-muted"><i class="fa text-theme far fas fa-language"></i> <a href="javascript:;" data-toggle="modal" data-target=".bd-example-modal-lg">{{ translate(32) }}</a></p>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- topbar-area end -->

	<!-- navbar start -->
	<div class="navbar-area bg-one navbar-area-fixed" id="cst__navbar">
		<nav class="navbar navbar-area navbar-expand-lg">
			<div class="container nav-container">
				<div class="responsive-mobile-menu">
					<button class="menu toggle-btn d-block d-lg-none" data-target="#banlank_main_menu" aria-expanded="false" aria-label="Toggle navigation">
						<span class="icon-left"></span>
						<span class="icon-right"></span>
					</button>
				</div>
				<div class="logo mr-auto d-block d-lg--none">
					<a href="{{ routeWithLocale('guest.index') }}">
						<img src="{{ asset_img('logo.png') }}" id="cst__logo" alt="">
					</a>
				</div>
				<div class="collapse navbar-collapse justify-content-end" id="banlank_main_menu">
					<ul class="navbar-nav w-auto menu-open">
						<li class="current-menu-item">
							<a href="{{ routeWithLocale('guest.index') }}">{{ translate(144) }}</a>
						</li>
						<li class="menu-item-has-children"><a href="{{ routeWithLocale('guest.bank_cards') }}">{{ translate(114) }}</a>
						    <ul class="sub-menu">
						        <li><a href="{{ routeWithLocale('guest.bank_cards', 'basic') }}">{{ translate(164) }}</a></li>
						        <li><a href="{{ routeWithLocale('guest.bank_cards', 'standard') }}">{{ translate(165) }}</a></li>
						        <li><a href="{{ routeWithLocale('guest.bank_cards', 'premium') }}">{{ translate(166) }}</a></li>
						    </ul>
						</li>
						<li class="menu-item-has-children"><a href="{{ routeWithLocale('guest.loans') }}">{{ translate(120) }}</a>
						    <ul class="sub-menu">
						    	@foreach (loans() as $uri => $loan)
						        	<li><a href="{{ routeWithLocale('guest.loans', $uri) }}">{{ translate($loan[0]) }}</a></li>
						    	@endforeach
						    </ul>
						</li>
						<li class="menu-item-has-children"><a href="{{ routeWithLocale('guest.insurance') }}">{{ translate(740) }}</a>
						    <ul class="sub-menu">
						    	@foreach (insurances() as $uri => $insurance)
						        	<li><a href="{{ routeWithLocale('guest.insurance', $uri) }}">{{ translate($insurance[0]) }}</a></li>
						    	@endforeach
						    </ul>
						</li>
						<li class="menu-item-has-children d-lg-none d-xl-none"><a href="javascript:;">{{ translate(140) }}</a>
						    <ul class="sub-menu">
						        <li><a href="{{ routeWithLocale('guest.login') }}">{{ translate(132) }}</a></li>
						        <li><a href="{{ routeWithLocale('guest.register') }}">{{ translate(134) }}</a></li>
						        <li><a href="{{ routeWithLocale('guest.password_forget') }}">{{ translate(137) }}</a></li>
						    </ul>
						</li>
						<li class="d-lg-none d-xl-none"><a href="{{ routeWithLocale('guest.loan_request') }}">{{ translate(79) }}</a></li>
						<li class="d-lg-none d-xl-none"><a href="{{ routeWithLocale('guest.contact') }}">{{ translate(147) }}</a></li>
						<li class="d-lg-none d-xl-none"><a href="javascript:;" data-toggle="modal" data-target=".bd-example-modal-lg"><i class="fa far fas fa-language"></i> {{ translate(32) }}</a></li>
						<li class="d-none d-lg-inline-block d-xl-inline-block">
							<a class="btn btn-round bg-theme" href="{{ routeWithLocale('guest.login') }}">{{ translate(140) }}</a>
						</li>
					</ul>
				</div>
			</div>
		</nav>
	</div>
	<!-- navbar end -->

	@if ( !isset($is_home) )
		<x-breadcrumb />
	@endif

	@yield('content')

	<!-- footer area start -->
	<footer class="footer-area bg-dark">
		<div class="container">
			<div class="footer-inner">
				<div class="row">
					<div class="col-lg-3 col-md-6 col-6">
						<div class="widget widget-address">
							<h4 class="widget-title mb-4 text-theme">{{ SITE_NAME }}.</h4>
							<p>{{ translate(310) }}</p>
							<p class="text-small">{{ translate(291) }}</p>
							<ul class="widget-list d-none">
								<li>{{ SITE_ADDRESS }}</li>

								@if (SHOW_PHONENUMBER_ON_HOMEPAGE)
									<li><a href="tel:{{ SITE_PHONE }}">{{ SITE_PHONE }}</a></li>
								@endif

								@if (SITE_ADDRESS_ALT)
									<li>{{ SITE_ADDRESS_ALT }}</li>
								@endif

								@if (SHOW_PHONENUMBER_ON_HOMEPAGE)
									@if (SITE_PHONE_ALT)
										<li><a href="tel:{{ SITE_PHONE_ALT }}">{{ SITE_PHONE_ALT }}</a></li>
									@endif
								@endif

								<li>
									<a href="mailto:{{ SITE_EMAIL }}">{{ SITE_EMAIL }}</a>
								</li>
							</ul>
						</div>
					</div>
					<div class="col-lg-2 col-md-6 col-6">
						<div class="widget widget-about">
							<h4 class="widget-title mb-4 text-theme">{{ translate(740) }}.</h4>
							<ul class="widget-list">
								@foreach (insurances() as $uri => $insurance)
									<li><a href="{{ routeWithLocale('guest.insurance', $uri) }}">{{ translate($insurance[0]) }}</a></li>
								@endforeach
							</ul>
						</div>
					</div>
					<div class="col-lg-2 col-md-6 col-6">
						<div class="widget widget-about">
							<h4 class="widget-title mb-4 text-theme">{{ translate(120) }}.</h4>
							<ul class="widget-list">
								@foreach (loans() as $uri => $loan)
									<li><a href="{{ routeWithLocale('guest.loans', $uri) }}">{{ translate($loan[0]) }}</a></li>
								@endforeach
							</ul>
						</div>
					</div>
					<div class="col-lg-2 col-md-6 col-6">
						<div class="widget widget-links"> 
							<h4 class="widget-title mb-4 text-theme">{{ translate(146) }}.</h4>
							<ul class="widget-list">
								<li><a href="{{ routeWithLocale('guest.security') }}">{{ translate(529) }}</a></li>
								<li><a href="{{ routeWithLocale('guest.helps') }}">{{ translate(138) }}</a></li>
								<li><a href="{{ routeWithLocale('guest.about') }}">{{ translate(379) }}</a></li>
								<li><a href="{{ routeWithLocale('guest.contact') }}">{{ translate(147) }}</a></li>
								<li><a href="{{ routeWithLocale('guest.testimonials') }}">{{ translate(156) }}</a></li>
							</ul>
						</div>
					</div>
					<div class="col-lg-3 col-md-6 col-6">
						<div class="widget widget-contact">
							<h4 class="widget-title mb-4 text-theme">{{ translate(147) }}.</h4>
							<p>{{ translate(254) }}</p>
							<ul class="social-area">
								@if (SITE_EMAIL)
									<li><a href="mailto:{{ SITE_EMAIL }}"><i class="fa fa-at"></i></a></li>
								@endif
								@if (SITE_WHATSAPP)
									<li><a href="{{ whatsapp_link() }}"><i class="fa fa-whatsapp"></i></a></li>
								@endif
								@if (SITE_PHONE)
									<li><a href="tel:{{ SITE_PHONE }}"><i class="fa fa-phone"></i></a></li>
								@endif
								@if (SITE_ADDRESS)
									<li><a target="_blank" href="{{ map_address() }}"><i class="fa fa-map-marker"></i></a></li>
								@endif
							</ul>
						</div>
					</div>

					<div class="col-lg-3 col-md-6 col-6">
						<div class="widget widget-about">
							<h4 class="widget-title mb-4 text-theme">{{ translate(697) }}.</h4>
							<ul class="widget-list">
								<li><a href="{{ routeWithLocale('guest.loans') }}">{{ translate(577) }}</a></li>
								<li><a href="{{ routeWithLocale('guest.loan_request') }}">{{ translate(79) }}</a></li>
							</ul>
						</div>
					</div>
					<div class="col-lg-3 col-md-6 col-6">
						<div class="widget widget-about">
							<h4 class="widget-title mb-4 text-theme">{{ translate(587) }}.</h4>
							<ul class="widget-list">
								<li><a href="{{ routeWithLocale('guest.bank_cards', 'basic') }}">{{ translate(115) }}</a></li>
								<li><a href="{{ routeWithLocale('guest.bank_cards', 'standard') }}">{{ translate(117) }}</a></li>
								<li><a href="{{ routeWithLocale('guest.bank_cards', 'premium') }}">{{ translate(118) }}</a></li>
							</ul>
						</div>
					</div>
					<div class="col-lg-3 col-md-6 col-6">
						<div class="widget widget-about">
							<h4 class="widget-title mb-4 text-theme">{{ translate(140) }}.</h4>
							<ul class="widget-list">
								<li><a href="{{ routeWithLocale('guest.register') }}">{{ translate(134) }}</a></li>
								<li><a href="{{ routeWithLocale('guest.login') }}">{{ translate(132) }}</a></li>
								<li><a href="{{ routeWithLocale('guest.password_forget') }}">{{ translate(136) }}</a></li>
							</ul>
						</div>
					</div>
					<div class="col-lg-3 col-md-6 col-6">
						<div class="widget widget-about">
							<h4 class="widget-title mb-4 text-theme">{{ translate(192) }}.</h4>
							<ul class="widget-list">
								<li><a href="{{ routeWithLocale('guest.bank_accounts') }}">{{ translate(193) }}</a></li>
								<li><a href="{{ routeWithLocale('guest.bank_accounts') }}">{{ translate(194) }}</a></li>
								<li><a href="{{ routeWithLocale('guest.bank_accounts') }}">{{ translate(195) }}</a></li>
							</ul>
						</div>
					</div>
				</div>

				<div class="row pt-3">
					<div class="col-12" id="footer-links">
						@foreach (legal_texts_endpoints() as $key => $name)
							@php
								\App\TranslationHelper::setActiveFolder( $key );
							@endphp
							<a class="text-white" href="{{ routeWithLocale('guest.legal_text', $key) }}">{{ translate($name) }}</a>
						@endforeach

						@php
						    \App\TranslationHelper::resetActiveFolder();
						@endphp
					</div>
				</div>

			</div>
		</div>
	</footer>
	<div class="footer-bottom">
		<div class="container">
			<div class="row">
				<div class="col-lg-6 align-self-center">
					<div class="text-lg-left text-center">
						<ul>
							<li><a href="{{ routeWithLocale('guest.helps') }}">{{ translate(149) }}</a></li>
							<li><a href="{{ routeWithLocale('guest.legal_notice') }}">{{ translate(152) }}</a></li>
							<li><a href="{{ routeWithLocale('guest.cookie_policy') }}">{{ translate(153) }}</a></li>
						</ul>
					</div>
				</div>
				<div class="col-lg-6 align-self-center">
					<div class="copy-right text-lg-right text-center">
						{!! site_copyright() !!}
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- footer area end -->

	<!-- back to top area start -->
	<div class="back-to-top">
		<span class="back-top"><i class="fa fa-angle-double-up"></i></span>
	</div>
	<!-- back to top area end -->

	<!-- Translate Modal box Starts -->
	<x-translation-modal-box />
	<!-- Translate Modal box End -->

	<!-- all plugins here -->
	<script type="text/javascript" src="{{ asset_js('default/vendor.js') }}"></script>

	<!-- main js  -->
	<script type="text/javascript" src="{{ asset_js('default/jquery.nice-select.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset_js('default/jquery.magnific-popup.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset_js('default/counter.js') }}"></script>
	<script type="text/javascript" src="{{ asset_js('default/jquery.waypoints.js') }}"></script>
	<script type="text/javascript" src="{{ asset_js('default/main.js') }}"></script>

	<!-- Smart wizard -->
	<script type="text/javascript" src="{{ asset_js("1000hz-validator.js") }} "></script>
	<script type="text/javascript" src="{{ asset_js("smart-wizard/jquery.smartWizard.js") }}"></script>
	<script type="text/javascript" src="{{ asset_js( "custom.smartwizard.js" ) }}"></script>
	<script type="text/javascript" src="{{ asset_js('default/custom.js') }}"></script>

	<!-- Angular js -->
	{{-- <script type="text/javascript" src="{{ asset_js('default/angular.min.js') }}"></script> --}}
	{{-- <script type="text/javascript" src="{{ asset_js('default/angular.default.js') }}"></script> --}}

	{{-- intl --}}
	<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
	<script type="text/javascript" src="{{ asset_js('iti.custom.js') }}"></script>

	<x-crisp-chat />
	
	@yield('script')
	@livewireScripts
</body>
</html>