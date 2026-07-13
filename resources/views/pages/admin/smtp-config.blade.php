@extends('layouts.admin')

@section('content')
	<section class="container-section">
		<div class="container">
			<div class="row">
				<div class="col-md-12 p-5 bg-white">
					<h1 class="mb-2">Configuration SMTP</h1>
					<p class="text-muted font-weight-bold mb-5">
						Gérer les paramètres utilisés pour envoyer les notifications email du site.
					</p>

					<form action="{{ routeWithLocale('admin.smtp_config.post') }}" method="post">
						@csrf

						<div class="row">
							<div class="col-lg-6">
								<div class="form-group">
									<label class="form-label">Serveur SMTP</label>
									<input type="text" name="MAIL_HOST" class="form-control bg-white @error('MAIL_HOST') is-invalid @enderror" value="{{ old('MAIL_HOST', $smtp['MAIL_HOST']) }}">
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-group">
									<label class="form-label">Port SMTP</label>
									<input type="number" name="MAIL_PORT" class="form-control bg-white @error('MAIL_PORT') is-invalid @enderror" value="{{ old('MAIL_PORT', $smtp['MAIL_PORT']) }}">
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-group">
									<label class="form-label">Identifiant SMTP</label>
									<input type="text" name="MAIL_USERNAME" class="form-control bg-white @error('MAIL_USERNAME') is-invalid @enderror" value="{{ old('MAIL_USERNAME', $smtp['MAIL_USERNAME']) }}">
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-group">
									<label class="form-label">Mot de passe SMTP</label>
									<input type="password" name="MAIL_PASSWORD" class="form-control bg-white @error('MAIL_PASSWORD') is-invalid @enderror" value="{{ old('MAIL_PASSWORD', $smtp['MAIL_PASSWORD']) }}">
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-group">
									<label class="form-label">Sécurité</label>
									<select name="MAIL_ENCRYPTION" class="form-control bg-white @error('MAIL_ENCRYPTION') is-invalid @enderror">
										@foreach (['tls' => 'TLS', 'ssl' => 'SSL', 'null' => 'Aucune'] as $value => $label)
											<option value="{{ $value }}" {{ old('MAIL_ENCRYPTION', $smtp['MAIL_ENCRYPTION']) == $value ? 'selected' : '' }}>{{ $label }}</option>
										@endforeach
									</select>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-group">
									<label class="form-label">Adresse expéditeur</label>
									<input type="email" name="MAIL_FROM_ADDRESS" class="form-control bg-white @error('MAIL_FROM_ADDRESS') is-invalid @enderror" value="{{ old('MAIL_FROM_ADDRESS', $smtp['MAIL_FROM_ADDRESS']) }}">
								</div>
							</div>
						</div>

						<div class="form-group mt-4">
							<button type="submit" class="btn font-weight-bold btn-xs btn-success">
								<i class="fa fa-check-circle"></i>
								<span>Mettre à jour le SMTP</span>
							</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</section>
@endsection
