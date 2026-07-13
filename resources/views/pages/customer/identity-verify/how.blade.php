@extends('pages.customer.identity-verify.layout')

@section('content')
	<div class="col-lg-9">
		<div class="bg-white p-4">
			<h2 class="admin-heading shadow-none text-info">{{ translate(763) }}</h2>
			
			<!-- Credit or Debit Cards  -->
			<div class="mt-3 p-4">
				<p>{{ translate(764) }}</p>
				<ol class="pl-5 py-3">
					<li>
						<p>{!! translate(765, false, $amount) !!}</p>
						
						<div class="py-2">
							<x-customer-rib-display :rib=$rib />
						</div>
					</li>
					<li class="font-weight-bold">{{ translate(766) }}</li>
					<li>{{ translate(767) }}</li>
				</ol>
				<p>{!! translate(768, false, $amount, $amount) !!}</p>
			</div>
			<!-- Credit or Debit Cards  -->
		</div>

	</div>
@endsection