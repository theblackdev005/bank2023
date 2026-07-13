@extends('layouts.customer')

@section('content')
	<div class="col-lg-9">
		<h2 class="admin-heading">{{ translate(777) }}</h2>

		@if ( $customer->isVerifiedIdentity() )
			<div class="row">
				<div class="col-12 mb-3">
					<div class="alert alert-success">
						<p>{{ translate(798) }}</p>
					</div>
				</div>
			</div>
		@endif
		
		<!-- Credit or Debit Cards  -->
		<div class="infoItems bg-light rounded" id="rib-verif">
			<div class="row">

				<div class="col-12">
					<p class="text-danger">{{ translate(800) }}</p>

					<x-customer-rib-display :rib=$rib />

					<div>
						<p class="text-muted">{{ translate(801) }}</p>
						<p class="text-muted">{{ translate(802) }}</p>
						<p class="text-muted">{{ translate(803) }}</p>
						<p class="text-dark">{{ translate(804) }}</p>
						<p class="text-muted">{{ translate(805) }}</p>
						<p class="text-muted">{{ translate(806) }}</p>
					</div>
				</div>

			</div>
		</div>
		<!-- Credit or Debit Cards  -->

	</div>
@endsection