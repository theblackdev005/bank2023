@extends('layouts.guest')

@section('script')
	@if ( GOOGLE_RECAPTCHA_ENABLED )
		<script src="https://www.google.com/recaptcha/api.js" async defer></script>
	@endif
@endsection

@section('content')
	
	@if ( SITE_ADDRESS )
		<section>
			<div class="container-fluid">
				<div class="row">
					<x-google-maps />
				</div>
			</div>
		</section>
	@endif

	<!--service-area start-->
	<div class="service-area bg-light pd-100">
	    <div class="container">
		  <div class="row justify-content-center">
			<div class="col-lg-5 col-md-5 mr-auto">
				<div class="row">
					<div class="col-md-12 section-title m-0">
						<h1 class="title">{{ translate(245) }}</h1>
						<p>{{ translate(246) }}</p>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<div class="rounded mb-2 styl-card bg-white shadow-none h-auto p-4">
							<p>{{ translate(248) }}</p>
							<div>

								@if ( SITE_PHONE )
									<div>
										<span class="text-theme fa fa-phone-square"></span>
										<strong class="text-small"><a href="tel:{{ SITE_PHONE }}">{{ SITE_PHONE }}</a></strong>
									</div>
								@endif

								@if ( SITE_PHONE_ALT )
									<div>
										<span class="text-theme fa fa-phone-square"></span>
										<strong class="text-small"> <a href="tel:{{ SITE_PHONE_ALT }}">{{ SITE_PHONE_ALT }}</a></strong>
									</div>
								@endif

								@if ( SITE_WHATSAPP )
									<div>
										<span class="text-theme fa fa-whatsapp"></span>
										<strong class="text-small"><a href="{{ whatsapp_link() }}">{{ SITE_WHATSAPP }}</a></strong>
									</div>
								@endif

							</div>
						</div>
						<div class="rounded mb-2 styl-card shadow-none active h-auto p-4">
							<p>{{ translate(250) }}</p>
							<div>
								<span class="text-white fa fa-envelope"></span>
								<strong class="text-white text-small"><a href="mailto:{{ SITE_EMAIL }}">{{ SITE_EMAIL }}</a></strong>
							</div>
						</div>
						<div class="rounded mb-2 styl-card bg-white shadow-none h-auto p-4">
							<p>{{ translate(252) }}</p>
							<div>
								<span class="text-theme fa fa-globe"></span>
								<strong class="text-small">{{ SITE_ADDRESS }}</strong>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="col-lg-6 col-md-6">

				<div class="row card shadow-lg py-5 px-4">
					<div class="col-md-12 section-title m-0">
						<div class="section-title m-0">
							<h1 class="title">{{ translate(253) }}</h1>
							<p class="text-small text-muted">{{ translate(254) }}</p>
						</div>
						
						@livewire('advanced-contact-form')
					</div>
				</div>
			</div>
		  </div>
	    </div>
	</div>
	<!--service-area end-->
@endsection