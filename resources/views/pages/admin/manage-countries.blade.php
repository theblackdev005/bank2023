@extends('layouts.admin')

@section('content')
	<section class="container-section">
		<div class="container">
			<div class="row">
				<div class="col-md-12 bg-white p-5 table-responsive">
					<h1 class="mb-5">Activer/Désactiver un pays.</h1>

					@livewire('admin-update-country-form')
				</div>
			</div>
		</div>
	</section>
@endsection