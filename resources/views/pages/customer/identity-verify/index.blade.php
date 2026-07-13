@extends('pages.customer.identity-verify.layout')

@section('content')
	<div class="col-lg-9">
		<div class="bg-white p-4">
			<h2 class="admin-heading shadow-none bg-white text-danger">{{ translate(769) }}</h2>

			<div class="alert-danger p-4 mb-3">
				<p class="text-dark">{{ translate(799) }}</p>
			</div>

			{{-- <div class="bg-light p-4 mb-3">
				<p class="text-muted">{{ translate(789) }}</p>
			</div> --}}
			
			<h2 class="admin-heading shadow-none bg-white">{{ translate(771) }}</h2>

			<div class="p-4">
				<div>
					<p>{!! translate(772, false, $customer->fullname()) !!}</p>
					<p>{{ translate(773) }}</p>
					<p>{!! translate(774, false, $amount) !!}</p>
					<p>{!! translate(775, false, $amount) !!}</p>
					<p>{{ translate(776) }}</p>
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