@extends('layouts.guest')

@section('content')
	<section class="two-partite shadow-none">
		<div class="container-fluid">
			<div class="row">
				<div class="col-lg-2 bg-with-covered-image" style="background-image: url({{ asset_img('security-1.jpg') }});"></div>
				<div class="col-lg-8">
					<div class="bg-with-covered-image auth-pd">
						<form method="POST" action="{{ routeWithLocale('guest.password_reset.post') }}">
							@csrf
							
							<div class="section-title mb-2">
								<h1 class="title text-theme pm-0">{{ translate(700) }}</h1>
								<p>{{ translate(724) }}</p>
							</div>
							<x-alert />

							<input type="hidden" name="token" value="{{ $token }}">
							<input type="hidden" name="email" value="{{ $email }}">
							<x-form-input type="password" label="{{ translate(653) }}" name="password"/>
							<x-form-input type="password" label="{{ translate(654) }}" name="password_confirmation"/>
							
							<div class="form-group">
								<button class="btn btn-dark btn-lg mt-1" type="submit">{{ translate(700) }}</button>
							</div>
						</form>
					</div>
				</div>
				<div class="col-lg-2 bg-with-covered-image" style="background-image: url({{ asset_img('security-1.jpg') }});"></div>
			</div>
		</div>
	</section>

	<section class="partners-section-horizontal shadow-none bg-light">
	    <x-partners></x-partners>
	</section>
@endsection