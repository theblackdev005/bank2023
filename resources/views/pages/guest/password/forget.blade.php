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
				<div class="col-lg-6 bg-with-covered-image" style="background-image: url({{ asset_img('security-1.jpg') }});"></div>
				<div class="col-lg-6">
					<div class="bg-with-covered-image auth-pd">
						<form method="POST" action="{{ routeWithLocale('guest.password_forget.post') }}">
							@csrf
							
							<div class="section-title mb-2">
								<h1 class="title text-theme pm-0">{{ translate(136) }}</h1>
								<p>{{ translate(207) }}</p>
							</div>
							<x-alert />

							<x-form-input placeholder="123456" label="{{ translate(203) }}" name="username"/>
							<x-recaptcha />
							
							<div class="form-group">
								<button class="btn btn-dark btn-lg mt-1" type="submit">{{ translate(208) }}</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</section>

	<div class="book-area py-5 bg-theme-dark">
	    <div class="container">
	        <div class="book-content text-center">
	            <h2>{{ translate(29) }}</h2>
	            <p>{{ translate(591) }}</p>
	            <a class="btn mt-4 btn-secondary" href="{{ routeWithLocale('guest.register') }}">
	                {{ translate(134) }}
	            </a>
	        </div>
	    </div>
	</div>

	<section class="partners-section-horizontal shadow-none bg-white">
	    <x-partners></x-partners>
	</section>
@endsection