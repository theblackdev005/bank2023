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
						<form method="POST" action="{{ routeWithLocale('guest.login.post') }}" class="form-need-validation0 mb-3">
							@csrf
							
							<div class="section-title mb-3">
								<h1 class="text-theme title pm-0">{{ translate(150) }}</h1>
								<div>
									<p>{{ translate(30) }}</p>
									<p><i class="fa fa-info-circle"></i> {{ translate(205) }} : <a class="text-bold text-theme" href="{{ routeWithLocale('guest.register') }}">{{ translate(134) }}</a>.</p>
								</div>
							</div>
							
							<x-alert></x-alert>

							@if ( LOGIN_USING_ACCOUNTNUMBER_AND_BIRTHDATE )
								<x-form-input type="text" name="account_number" placeholder="### ### ##" label="{{ translate(646) }}" />
								<div class="form-group">
									<label class="required-field">{{ translate(187) }}:</label>
									<div class="row">
										<div class="col-3">
											<x-form-input
												type="text" 
												name="birth_date.day" 
												placeholder="DD" 
												pattern="[0-9]{2}" />
										</div>
										<div class="col-3">
											<x-form-input
												type="text" 
												name="birth_date.month" 
												placeholder="MM" 
												pattern="[0-9]{2}" />
										</div>
										<div class="col-6">
											<x-form-input
												type="text" 
												name="birth_date.year" 
												placeholder="YYYY" 
												pattern="[0-9]{4}" />
										</div>
									</div>
								</div>
							@else

								@if ( LOGIN_USING_EMAIL_AND_PASSWORD )
									<x-form-input
										type="text" 
										name="email" 
										label="{{ translate(257) }}" />
								@else
									<x-form-input
										type="text" 
										name="username" 
										label="{{ translate(487) }}" />
								@endif

								<x-form-input
									type="password" 
									name="password" 
									label="{{ translate(204) }}" />
							@endif

							<x-recaptcha></x-recaptcha>
							
							<div class="form-group">
								<button type="submit" class="btn btn-success btn-lg mt-1">{{ translate(150) }}</button>
							</div>
							<div class="mt-5">
								<p class="text-danger">{!! translate(642) !!}</p>
							</div>
						</form>
					</div>
				</div>
				<div class="col-lg-6 bg-with-covered-image" style="background-image: url({{ asset_img('default/pages/login__left.jpg') }});"></div>
			</div>
		</div>
	</section>

	<!-- partner area start -->
	<div class="partner-area bg-white">
	    <x-partners></x-partners>
	</div>
	<!-- partner area end -->
@endsection