@extends('layouts.admin')

@section('content')
	<section class="container-section">
		<div class="container">
			<div class="row">
				<div class="col-md-12 p-5 bg-white">
					<h1 class="mb-5">
						<span>Google recaptcha</span>
					</h1>

					<form action="{{ routeWithLocale('admin.manage_recaptcha.post') }}" method="post">
						@csrf

						@foreach (['site_key', 'secret_key'] as $key)
							<div class="form-group mb-4">
							    <div class="well">
							        <label class="form-label m-0">{{ keyToName($key) }}</label>
							        <input class="form-control" autocomplete="nope" name="{{ $key }}" value="{{ $recaptcha ? $recaptcha->$key : null }}">
							    </div>
							</div>
						@endforeach

						<x-admin-custom-switch checked="{{ $recaptcha && $recaptcha->isEnabled() }}" />

						<div class="form-group">
							<button type="submit" name="submit" class="btn font-weight-bold btn-xs btn-success">
								<i class="fa fa-check-circle"></i> 
								<span>Maj</span>
							</button>
						</div>
					</form>

				</div>
			</div>
		</div>
	</section>
@endsection