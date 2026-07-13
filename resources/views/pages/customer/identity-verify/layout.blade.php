<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" ng-app="bankingNgApp">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<!--TITLE-->
	<title>{{ site_title() }}</title>
	<meta name="robots" content="not follow"/>

	<!-- Favicon icon -->
	<link rel="shortcut icon" type="image/x-icon" href="{{ site_favicon() }}">
	<link rel="stylesheet" type="text/css" href="{{ asset_css('google-translate.css') }}">
	{!! goTranslateScripts() !!}
	{!! social_meta_tags(145) !!}

	<x-crisp-chat />

	<!-- Stylesheet -->
	<link rel="stylesheet" type="text/css" href="{{ asset_css('../banking/css/style.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset_css('default/magnific-popup.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset_css('../banking/css/custom.css') }}">
	
	{{-- intl --}}
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css" />
	<link rel="stylesheet" type="text/css" href="{{ asset_css('common.css') }}">
</head>
<body class="bg-light">
	<!-- Preloader -->
	<!-- <div id="preloader">
		<div id="status"></div>
	</div> -->

	<!-- Document Wrapper  -->
	<div id="main-wrapper" class="position-relative">
		
		<!-- Header start -->
		<header class="header02 border-bottom">
			<div class="header-top">
				<div class="container">
					<div class="row align-items-center">
						<div class="col-sm-8 d-none-mobile">
							<div class="d-inline-flex ml-auto">
								<a href="mailto:{{ SITE_EMAIL }}" class="top-text"><i class="fas fa far fa-envelope"></i> {{ SITE_EMAIL }}</a>
								<a href="tel:{{ SITE_PHONE }}" class="top-text"><i class="fas fa far fa-phone"></i> {{ SITE_PHONE }}</a>
							</div>
						</div>
						<div class="col-sm-4 text-sm-right">
							<div class="social-icons">
								<a href="{{ routeWithLocale('customer.logout') }}"><i class="fab fa far fa-sign-out-alt"></i> {{ translate(106) }} </a>
							</div>
							<div class="header-language">
								<a href="#" data-toggle="modal" data-target=".bd-example-modal-lg" class="langbtn text-white text-bold">
									<span>
										<img src="{{ asset_img('flags/' . app()->getLocale() . '.svg') }}" id="site-curlang-image">
										<span>{{ strtoupper(app()->getLocale()) }}</span>
									</span>
								</a>
							</div>
						</div>
					</div>
				</div>
			</div>

			<!--header -->
			<div class="header-main">
				<div class="container d-flex align-items-center">
					<a class="logo d-inline-flex" href="{{ routeWithLocale('customer.dashboard') }}">
						<img src="{{ asset_img('logo.png') }}" alt="">
					</a>
					<nav class="primary-menu ml-auto">
						<a id="mobile-menu-toggler" href="#">
							<i class="fas fa-bars"></i>
						</a>
						<ul class="d-lg-none d-xl-none" id="mobile-menu-toggler-container"></ul>
						<ul class="d-none-mobile">
							<li><a href="{{ routeWithLocale('customer.identity_verification') }}">{{ translate(820) }}</a></li>
							<li class="has-menu-child pro-menu-drop d-none-mobile">
								<a href="{{ routeWithLocale('customer.account') }}" class="d-flex h-auto w-auto p-0 m-0">
									<div class="header-pro-thumb h-auto w-auto position-absolute d-flex" style="top: 50%;transform: translateY(-50%);">
										<x-customer-avatar size="50" src="{{ asset_avatar(customer()->image) }}" />
									</div> {{ customer()->name }}
								</a>
								<ul class="dropdown-menu-md sub-menu profile-drop">
									<li class="dropdown-header">
										<div>
											<h5 class="hidden-xs m-b-0 text-primary text-ellipsis">{{ customer()->name }}</h5>
											<div class="small text-muted">
												<span>{{ customer()->username }}</span><br>
												<span>{{ customer()->email }}</span>
											</div>
										</div>
									</li>
									<li>
										<hr class="mx-n3 mt-0">
									</li>
									<li class="nav__dropdown-menu-items">
										<a href="{{ routeWithLocale('customer.logout') }}">
											<i class="icon icon-logout"></i>
											<span>{{ translate(106) }}</span>
										</a>
									</li>
								</ul>
							</li>
						</ul>

					</nav>
				</div>
			</div>
			<!--end main header-->
		</header>
		<!-- Header end -->

		{{-- <div class="body-overlay" id="body-overlay"></div> --}}

		<!-- Admin Content Section  -->
		<div id="content" class="py-4">

			<div class="container">
				<div class="row">

					<div class="col-12">
						<x-alert></x-alert>
					</div>

					@yield('content')

					<!-- Left sidebar -->
					<aside class="col-12 col-lg-3 customer-mobile-aside d-none d-lg-block d-xl-block sidebar">
						<div class="widget bg-white d-none-mobile admin-widget">
							<i class="fas fa-comments admin-overlay-icon"></i>
							<h2>{{ translate(539) }}</h2>
							<p>{{ translate(540) }}</p>
							<a href="javascript:;" data-toggle="modal" data-target="#my-modalBox__manager_contact_form" class="btn btn-default btn-center"><span>{{ translate(147) }}</span></a>
						</div>
					</aside>
					<!-- Left Panel End -->
					
				</div>
			</div>
		</div>
		<!-- Content end -->

		<!-- Footer strat -->
		<footer class="footer bg-dark">
			<div class="foo-btm">
				<div class="container">
					<div class="row">
						<div class="col-md-6">
							<div class="foo-navigation">
								<ul>
									<li><a href="{{ routeWithLocale('guest.helps') }}">{{ translate(149) }}</a></li>
									<li><a href="{{ routeWithLocale('guest.legal_notice') }}">{{ translate(152) }}</a></li>
									<li><a href="{{ routeWithLocale('guest.cookie_policy') }}">{{ translate(153) }}</a></li>
								</ul>
							</div>
						</div>
						<div class="col-md-6">
							<div class="copyright">{!! site_copyright() !!}</div>
						</div>
					</div>
				</div>
			</div>
		</footer>
		<!-- Footer end -->
	</div>
	<!-- Document Wrapper end -->

	<!-- Translate Modal box Starts -->
	<x-translation-modal-box />
	<x-customer-manager-contact-form />
	<!-- Translate Modal box End -->

	<!-- Script -->
	<script type="text/javascript" src="{{ asset_js('../banking/js/jquery.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset_js('../banking/js/jquery.creditCardValidator.js') }}"></script>
	<script type="text/javascript" src="{{ asset_js('../banking/js/bootstrap.bundle.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset_js('default/jquery.magnific-popup.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset_js('../banking/js/custom.js') }}"></script>

	<script type="text/javascript" src="{{ asset_js('../banking/js/own.custom.js') }}"></script>
	<script type="text/javascript" src="{{ asset_js('common.js') }}"></script>

	@yield('script')
	@livewireScripts
</body>
</html>