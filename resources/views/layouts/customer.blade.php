<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" ng-app="bankingNgApp">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="csrf-token" content="{{ csrf_token() }}">

	@if ( !empty($loadsection["rest"]) )
		<meta http-equiv="refresh" content="{{ $loadsection["rest"]+10 }}">
	@endif

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

	@yield('style')
	@livewireStyles
</head>
<body>
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
							<li><a href="{{ routeWithLocale('customer.dashboard') }}">{{ translate(98) }}</a></li>
							<li><a href="{{ routeWithLocale('customer.recipients') }}">{{ translate(103) }}</a></li>
							<li><a href="{{ routeWithLocale('customer.add_transferts') }}"><i class="fa fa-plus"></i> {{ translate(396) }}</a></li>
							<li><a href="{{ routeWithLocale('customer.cards') }}">{{ translate(587) }}</a></li>
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
									<li class="nav__create-new-profile-link">
										<a href="{{ routeWithLocale('customer.account') }}">
											<span>{{ translate(542) }}</span>
										</a>
									</li>
									<li class="divider"></li>
									<li class="nav__dropdown-menu-items">
										<a href="{{ routeWithLocale('customer.sessions') }}">
											<i class="icon icon-setting"></i>
											<span>{{ translate(102) }}</span>
										</a>
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

		<!-- Admin Hero section-->
		<div class="hero-section d-none-mobile">
			<div class="container">
				<div class="row  profile-complete-area">
					<div class="col">
						<div class="progress" data-percentage="100">
							<span class="progress-left">
								<span class="progress-bar"></span>
							</span>
							<span class="progress-right">
								<span class="progress-bar"></span>
							</span>
							<div class="progress-value h-100 w-100 overflow-hidden">
								<div class="profile-thumb h-100 w-100 mt-3 mb-4">
									<x-customer-avatar src="{{ asset_avatar(customer()->image) }}" />
								</div>
							</div>
						</div>
						<p class="profile-name">{{ customer()->fullname() }}</p>
					</div>
					<div class="col d-none-mobile">
						<div class="profile-item bg-white">
							<i class="fas fa-mobile-alt bg-icon text-theme-light"></i>
							<i class="fas fa-check-circle Verified-icon"></i>
							<p class="title">{{ translate(191) }}</p>
						</div>
					</div>
					<div class="col d-none-mobile">
						<div class="profile-item bg-white">
							<i class="fas fa-envelope bg-icon text-theme-light"></i>
							<i class="fas fa-check-circle Verified-icon"></i>
							<p class="title">{{ translate(184) }}</p>
						</div>
					</div>
					<div class="col">
						<a href="{{ routeWithLocale('customer.add_cards') }}">
							<div class="profile-item bg-white">
								<i class="fas fa-credit-card bg-icon text-theme"></i>
								<i class="far fa fas fa-plus-circle bg-theme Verified-icon"></i>
								<p class="title">{{ translate(114) }}</p>
							</div>
						</a>
					</div>
					<div class="col">
						<a href="{{ routeWithLocale('customer.add_transferts') }}">
							<div class="profile-item bg-white">
								<i class="fas fa-university bg-icon text-theme"></i>
								<i class="far fa fas bg-theme fa-plus-circle Verified-icon"></i>
								<p class="title">{{ translate(396) }}</p>
							</div>
						</a>
					</div>
				</div>

			</div>
		</div>
		<!-- Admin End of Hero section-->

		<!-- Profile bar Section -->
		<section class="profilebar d-none d-lg-block d-xl-block">
			<div class="container">
				<div class="row">
					<div class="col">
						<div class="balance-area">
							<select name="ctl00$ddlAccounts" class="custom-select">
								<option>{{ customer()->currency->name }} - {{ customer()->username }}</option>
							</select>
						</div>
					</div>
					<div class="col">
						<p class="total-blance text-bold text-success">
							{{ setCurrency(customer()->currency, customer()->balance) }}
						</p>
					</div>
					<div class="col">
						<div class="local-time text-warning">
							<p><i class="fa fa-star"></i> <b>{{ translate( customer()->account_type ) }}</b></p>
						</div>
					</div>
					<div class="col">
						<div class="local-time">
							<p><b>{{ translate( 366 ) }}:</b> {{ customer()->last_login_at }}</p>
						</div>
					</div>
				</div>
			</div>
		</section>

		@if ( $errors->any() )
			<section class="pt-2 pb-0">
				<div class="container">
					<div class="row">
						<div class="col-lg-12">
							<x-alert />
						</div>
					</div>
				</div>
			</section>
		@endif

		<section class="d-lg-none d-xl-none mt-3 p-0">
			<div class="container">
				<div class="row">
					<div class="col-12">
						<div class="card bg-light rounded shadow border">
							<div class="card-body">
								<div class="d-flex justify-content-between">
									<div>
										<p class="text-muted text-uppercase m-0">{{ translate( customer()->account_type ) }}</p>
										<h4 class="m-0 font-weight-bold">{{ customer()->username }}</h4>
									</div>
									<div>
										<x-customer-avatar size="50" src="{{ asset_avatar(customer()->image) }}" />
									</div>
								</div>
								<hr>
								<div class="text-right">
									<p class="text-muted m-0">{{ translate(392) }}</p>
									<h3 class="m-0 font-weight-bold">{{ setCurrency(customer()->currency, customer()->balance) }}</h3>
								</div>
							</div>
							<div class="card-footer border-0 text-right bg-theme-light">
								@if ( customer()->balance <= 0 )
									<a class="text-theme" href="{{ routeWithLocale('customer.add_loans') }}">{{ translate(356) }} »</a>
								@else
									<a class="text-theme" href="{{ routeWithLocale('customer.add_transferts') }}">{{ translate(410) }} »</a>
								@endif
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- End Profile bar Section -->

		<!-- Admin Content Section  -->
		<div id="content" class="py-4">
			<div class="container">
				<div class="row">

					<!-- Left sidebar -->
					<aside class="col-12 col-lg-3 customer-mobile-aside d-none d-lg-block d-xl-block sidebar">
						<div class="widget admin-widget p-0">
							<div class="Profile-menu">
								<ul class="nav secondary-nav" id="mobile-menu-toggler-content"> 
									<li class="nav-item{{ active_menu_item('customer.dashboard') }}"><a class="nav-link" href="{{ routeWithLocale('customer.dashboard') }}"><i class="fas fa-tachometer-alt"></i>{{ translate(98) }}</a></li>
									<li class="nav-item"><hr class="m-0"></li>
									<li class="nav-item{{ active_menu_item('customer.add_recipients') }}"><a class="nav-link" href="{{ routeWithLocale('customer.add_recipients') }}"><i class="fa fa-plus"></i>{{ translate(104) }}</a></li>
									<li class="nav-item{{ active_menu_item('customer.recipients') }}"><a class="nav-link" href="{{ routeWithLocale('customer.recipients') }}"><i class="fa fa-user"></i>{{ translate(400) }}</a></li>
									<li class="nav-item"><hr class="m-0"></li>
									<li class="nav-item{{ active_menu_item('customer.transactions') }}"><a class="nav-link" href="{{ routeWithLocale('customer.transactions') }}"><i class="fa fa-list"></i>{{ translate(394) }}</a></li>
									<li class="nav-item{{ active_menu_item(['customer.add_transferts']) }}"><a class="nav-link" href="{{ routeWithLocale('customer.add_transferts') }}"><i class="fas fa-plus"></i>{{ translate(410) }}</a></li>
									<li class="nav-item{{ active_menu_item(['customer.transferts', 'customer.show_transfert']) }}"><a class="nav-link" href="{{ routeWithLocale('customer.transferts') }}"><i class="fa fa-list"></i>{{ translate(396) }}</a></li>
									<li class="nav-item"><hr class="m-0"></li>
									<li class="nav-item{{ active_menu_item(['customer.cards', 'customer.add_cards']) }}"><a class="nav-link" href="{{ routeWithLocale('customer.cards') }}"><i class="fa fa-credit-card"></i>{{ translate(114) }}</a></li>
									<li class="nav-item"><hr class="m-0"></li>
									<li class="nav-item{{ active_menu_item(['customer.rib']) }}"><a class="nav-link" href="{{ routeWithLocale('customer.rib') }}"><i class="fa fa-info-circle"></i>{{ translate(777) }}</a></li>
									<li class="nav-item"><hr class="m-0"></li>
									<li class="nav-item{{ active_menu_item('customer.loans') }}"><a class="nav-link" href="{{ routeWithLocale('customer.loans') }}"><i class="fas fa-piggy-bank"></i>{{ translate(398) }}</a></li>
									<li class="nav-item{{ active_menu_item('customer.add_loans') }}"><a class="nav-link" href="{{ routeWithLocale('customer.add_loans') }}"><i class="fa fa-plus"></i>{{ translate(356) }}</a></li>
									<li class="nav-item"><hr class="m-0"></li>
									<li class="nav-item{{ active_menu_item('customer.sessions') }}"><a class="nav-link" href="{{ routeWithLocale('customer.sessions') }}"><i class="fas fa-user"></i>{{ translate(102) }}</a></li>
									<li class="nav-item{{ active_menu_item(['customer.account', 'customer.edit_account', 'customer.edit_password']) }}"><a class="nav-link" href="{{ routeWithLocale('customer.account') }}"><i class="fas fa-cog"></i>{{ translate(542) }}</a></li>
								</ul>
							</div>
						</div>
						<div class="widget d-none-mobile admin-widget">
							<i class="fas fa-comments admin-overlay-icon"></i>
							<h2>{{ translate(539) }}</h2>
							<p>{{ translate(540) }}</p>
							<a href="javascript:;" data-toggle="modal" data-target="#my-modalBox__manager_contact_form" class="btn btn-default btn-center"><span>{{ translate(147) }}</span></a>
						</div>
					</aside>
					<!-- Left Panel End -->

					@yield('content')
					
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
	<script type="text/javascript" src="{{ asset_js('../banking/js/moment.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset_js('../banking/js/daterangepicker.js') }}"></script>
	<script type="text/javascript" src="{{ asset_js('../banking/js/bootstrap-select.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset_js('default/jquery.magnific-popup.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset_js('../banking/js/custom.js') }}"></script>

	<script type="text/javascript" src="{{ asset_js("../banking/js/progressbar.js") }}"></script>
	<script type="text/javascript" src="{{ asset_js('../banking/js/own.custom.js') }}"></script>
	<script type="text/javascript" src="{{ asset_js('common.js') }}"></script>

	<!-- Angular js -->
	<script type="text/javascript" src="{{ asset_js('../banking/js/angular.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset_js('../banking/js/angular.banking.js') }}"></script>

	{{-- intl --}}
	<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
	<script type="text/javascript" src="{{ asset_js('iti.custom.js') }}"></script>

	<script>
		document.addEventListener('DOMContentLoaded', function () {
			if (!window.Intl || !window.fetch) return;

			const timezone = Intl.DateTimeFormat().resolvedOptions().timeZone || '';
			const savedTimezone = @json(customer()->timezone);
			const loginUrl = @json(routeWithLocale('guest.login'));

			if (timezone && timezone !== savedTimezone) {
				fetch(@json(routeWithLocale('customer.timezone.update')), {
					method: 'POST',
					headers: {
						'Content-Type': 'application/json',
						'Accept': 'application/json',
						'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
					},
					body: JSON.stringify({ timezone: timezone })
				});
			}

			const heartbeat = function () {
				fetch(@json(routeWithLocale('customer.session.heartbeat')), {
					method: 'POST',
					headers: {
						'Accept': 'application/json',
						'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
					}
				}).then(function (response) {
					if (response.redirected || response.status === 401 || response.status === 419) {
						window.location.href = response.redirected ? response.url : loginUrl;
					}
				}).catch(function () {
					// A temporary network interruption must not replace the current page.
				});
			};

			window.setInterval(heartbeat, 60000);
		});
	</script>

	@yield('script')
	@livewireScripts
</body>
</html>
