@extends('layouts.guest')

@section('script')
	@if ( GOOGLE_RECAPTCHA_ENABLED )
		<script src="https://www.google.com/recaptcha/api.js" async defer></script>
	@endif
@endsection

@section('content')
	<section class="two-partite shadow-none">
		<div class="container-fluid">
			<div class="row">
				<div class="col-lg-6 bg-white">
					<div class="bg-with-covered-image auth-pd">
						<form method="POST" action="{{ routeWithLocale('guest.password_forget.post') }}">
							@csrf
							
							<div class="section-title mb-2">
								<h1 class="title text-theme pm-0">{{ translate(136) }}</h1>
								<p>{{ translate(207) }}</p>
							</div>
							<x-alert />

							<x-form-input label="{{ translate(203) }}" name="username"/>
							<x-recaptcha />
							
							<div class="form-group d-flex flex-wrap align-items-center">
								<button class="btn btn-success btn-lg mr-2 mb-2" type="submit">{{ translate(208) }}</button>
								<a class="btn btn-dark btn-lg mb-2" href="{{ routeWithLocale('guest.login') }}">{{ translate(132) }}</a>
							</div>
							<p class="text-muted mb-0">{{ translate(205) }} : <a class="text-theme font-weight-bold" href="{{ routeWithLocale('guest.register') }}">{{ translate(134) }}</a>.</p>
						</form>
					</div>
				</div>
				<div class="col-lg-6 bg-with-covered-image" style="background-image: url({{ asset_img('security-1.jpg') }});"></div>
			</div>
		</div>
	</section>

	<section class="partners-section-horizontal shadow-none bg-white">
	    <x-partners></x-partners>
	</section>
@endsection
