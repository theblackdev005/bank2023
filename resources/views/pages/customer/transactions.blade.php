@extends('layouts.customer')

@section('content')
	<div class="col-lg-9"> 
		<h2 class="admin-heading bg-offwhite">
			{{ translate(388) }}
			<a class=" btn-link ml-2" href="{{ routeWithLocale('customer.download_transactions') }}"><i class="far fa-file-excel"></i></a>
		</h2>

		<!-- All Transactions  -->
		<div class="profile-content">
		   
			<!-- Admin Heading Title  -->
			<div class="transaction-title bg-offwhite">
				<div class="items">
					<div class="row">
						<div class="col"><span class="">#</span></div>
						<div class="col-6">{{ translate(389) }}</div>
						<div class="col-2 text-center">{{ translate(390) }}</div>
						<div class="col-2">{{ translate(629) }}</div>
					</div>
				</div>
			</div>
			<!-- Admin Heading Title End -->

			<!-- Transaction List -->
			<div class="transaction-area">

				@php
					extract($transactions);
				@endphp

				@forelse ($data as $date => $transaction)

					@foreach ($transaction as $transact)
						<div class="items">
							<div class="row">
								<div class="col pay-date">
									<span class="date">{{ $transact->uniqid }}</span>
								</div>
								<div class="col-6">
									<span class="name">{{ translate($transact->description) }}</span>
								</div>
								<div class="col-2 text-center">
									<span class="payments-status text-{{ $transact->type_html_clx }}">
										{{ translate($transact->type_str) }}
									</span>
									<span class="payment-amaount">{{ setCurrency($transact->currency, $transact->cost) }}</span>
								</div>
								<div class="col-2">
									<span class="currency">
										<span>{{ dateFormat($transact->created_at, 1) }}</span><br>
										<span>{{ dateFormat($transact->created_at, 2) }}</span>
									</span>
								</div>
							</div>
						</div>
					@endforeach

				@empty
					<show-empty-data-message />
				@endforelse
				
			</div>
			<!-- Transaction List End -->

			<!-- Pagination -->
			<x-paginator :items=$pagination_data />
			<!-- Paginations end -->

		</div>
		<!-- All Transactions End -->
	</div>
@endsection