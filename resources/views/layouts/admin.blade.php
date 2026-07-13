<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" xmlns:og="http://ogp.me/ns#">
<head>
	<title>{{ site_title() }}</title>
	<meta name="robots" content="not follow"/>
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link rel="shortcut icon" type="image/x-icon" href="{{ site_favicon() }}">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<link rel="stylesheet" type="text/css" href="{{ asset_css('admin/bootstrap.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset_css('admin/custom.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset_css('google-translate.css') }}">
	
	{{-- intl --}}
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css" />
	<link rel="stylesheet" type="text/css" href="{{ asset_css('common.css') }}">
	
	{!! goTranslateScripts() !!}

	@yield('style')
	@livewireStyles
</head>
<body>

	@auth('admin')
		<nav class="navbar navbar-expand-md navbar-light bg-white text-center">
			<div class="container">
				<a class="navbar-brand" href="{{ routeWithLocale('admin.dashboard') }}" id="my-logo">
					<img src="{{ asset_img('logo.png') }}" alt="">
				</a>
			</div>
		</nav>
	
		<nav class="navbar navbar-expand-md navbar-dark bg-dark">
			<div class="container">

				<ul class="navbar-nav">
					<li class="nav-item"><a class="nav-link" href="{{ routeWithLocale('admin.dashboard') }}"><i class="fa fa-dashboard mr-1"></i>{{ translate(109) }}</a></li>
					<li class="nav-item"><a class="nav-link" href="{{ routeWithLocale('admin.add_customer') }}"><i class="fa fa-plus mr-1"></i>{{ translate(110) }}</a></li>
					<li class="nav-item"><a class="nav-link" href="{{ routeWithLocale('theme.index') }}" target="_blank"><i class="fa fa-palette mr-1"></i>{{ translate(734) }}</a></li>
					<li class="nav-item"><a class="nav-link" href="{{ routeWithLocale('admin.helps') }}"><i class="fa fa-question-circle mr-1"></i>{{ translate(539) }}</a></li>
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<i class="fa fa-cog mr-1"></i> Paramètres
						</a>
						<div class="dropdown-menu" aria-labelledby="navbarDropdown">
							<a class="dropdown-item" href="{{ routeWithLocale('admin.edit_account') }}"><i class="fa fa-edit mr-1"></i>{{ translate(112) }}</a>
							<a class="dropdown-item" href="{{ routeWithLocale('admin.edit_password') }}"><i class="fa fa-lock mr-1"></i>{{ translate(113) }}</a>
							<a class="dropdown-item" href="{{ routeWithLocale('admin.logout') }}">
								<span class=""><i class="fa fa-power-off mr-1"></i>{{ translate(141) }}</span>
							</a>
						</div>
					</li>
				</ul>
				<ul class="nav navbar-nav top-menu navbar-right">
					<li class="nav-item">
						<a class="nav-link" href="javascript:;" data-toggle="modal" data-target=".bd-example-modal-lg">
							<i class="mr-1">
								<img src="{{ asset_img("flags/" . app()->getLocale() . ".svg") }}" style="height:20px;" alt="">
							</i>
						</a>
					</li>
				</ul>

			</div>
		</nav>

		@if ( !isset($errors) )
			<section class="breadcrumb-m bg-white pt-1 pb-1">
			    <div class="container">
			        <div class="row">
			            <div class="col-xs-12">
			                 <span>{{ translate(144) }} > {{ page_name() }}</span>
			            </div>
			        </div>
			    </div>
			</section>
		@else
			<div class="container pt-2 px-0">
				<div class="row w-100 d-block m-0">
					<x-alert />
				</div>
			</div>
		@endif
	@endauth

	@yield('content')

	<footer class="footer">
		<div class="footer-bottom">
			<div class="container">
				<div class="row">
					<div class="col-12 text-center">
						<span>{!! site_copyright() !!}</span>
					</div>
				</div>
			</div>
		</div>
	</footer>

	<!-- Translate Modal box Starts -->
	<x-translation-modal-box />
	<!-- Translate Modal box End -->

	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.6/dist/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.2.1/dist/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>

	<script type="text/javascript" src="{{ asset_js("admin/application.js") }}"></script>
	<script type="text/javascript" src="{{ asset_js('common.js') }}"></script>

	{{-- intl --}}
	<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
	<script type="text/javascript" src="{{ asset_js('iti.custom.js') }}"></script>

	@yield('script')
	@livewireScripts
</body>
</html>