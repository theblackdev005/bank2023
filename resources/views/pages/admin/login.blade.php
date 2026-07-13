@extends('layouts.admin')

@section('script')
	@if ( GOOGLE_RECAPTCHA_ENABLED )
		<script src="https://www.google.com/recaptcha/api.js" async defer></script>
	@endif
@endsection

@section('content')
	<section class="py-5">
		<div class="container">
			<div class="row">
				<div class="login_form col-12 col-md-4 offset-md-4">
					<div class="card">
						<div class="card-body">
							<div class="text-center pb-5">
								<a class="navbar-brand" href="{{ routeWithLocale('admin.login') }}" id="my-logo">
									<img src="{{ asset_img('logo.png') }}" alt="">
								</a>
							</div>
							<form action="" method="post">
								@csrf

								<x-alert />
								
								<div class="form-group">
									<label class="form-label">Identifiant:</label>
									<input type="text" autocapitalize="none" autocomplete="nope" autocorrect="off" class="form-control input-lg" name="username"/>
								</div>
								<div class="form-group">
									<label class="form-label">Mot de passe:</label>
									<input type="password" autocapitalize="none" autocomplete="nope" autocorrect="off" class="form-control input-lg" name="password"/>
								</div>
								<div class="form-group">
									<x-recaptcha/>
								</div>
								<div class="form-group">
									<button type="submit" class="btn btn-success btn-block btn-lg full-m">Se connecter</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
@endsection