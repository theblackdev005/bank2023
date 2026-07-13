@extends('layouts.customer')

@section('content')
	<div class="col-lg-9">
		<div class="bg-white p-4">
			<h2 class="admin-heading shadow-none bg-white text-danger">{{ translate(707) }}</h2>

			<div class="p-4">
				<div>
					<p>{{ translate(827) }}</p>
					<p>{{ translate(828, false, $customer->admin->email) }}</p>
					<p>{{ translate(829) }}</p>
					<p>{{ translate(830) }}</p>
					<p>{{ translate(831) }}</p>
				</div>

				<div class="pt-3 text-right">
					<a href="{{ routeWithLocale('customer.identity_verification', 'how') }}" class="btn btn-success text-white position-relative">
						<i class="fa fa-check-circle"></i>
						<span>{{ translate(797) }}</span>
					</a>
				</div>
			</div>
		</div>
	</div>
@endsection