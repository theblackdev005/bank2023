@extends('layouts.customer')

@section('content')
	<div class="col-lg-9">
		<h2 class="admin-heading bg-offwhite">{{ translate(519) }}</h2>
		
		<div class="row pb-2">

			@if ( $rib )
				<div class="col-12 py-3">
					<h4>{{ translate(777) }}</h4>
					<x-customer-rib-display :rib=$rib />
				</div>
			@endif

			<div class="col-12 col-lg-12">
				@php
					$body_contents = ''
				@endphp

				@foreach ($stats_details as $mskey => $detail)
					@php
						ob_start()
					@endphp
						<div class="col-md-4 col-lg-4 col-12 mb-2 col-sm-4 d-flex">
							<a href="{{ routeWithLocale($detail['url']) }}" class="card w-100" style="text-decoration: none!important;">
								
								<div class="card-body d-flex w-100">
								    <div>
								    	<h6 class="card-title">{{ translate($detail['title']) }}</h6>
								    	<h1 class="text-block fz-50 text-theme pm-0">{{ $stats[$detail['count']] }}</h1>
								    	<p class="card-text text-secondary">{{ translate($detail['desc']) }}</p>
								    </div>
								</div>

							</a>
						</div>
					@php
						$body_contents .= ob_get_clean();
						$mskey2 = $mskey + 1;
					@endphp

					@if ( ($mskey2 % 3) == 0 )
						<div class="row mb-4 d-flex flex-wrap">
							{!! $body_contents !!}
							@php
								$body_contents = ''
							@endphp
						</div>
					@endif

				@endforeach
			</div>

		</div>

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
						<div class="col-2">{{ translate(393) }}</div>
					</div>
				</div>
			</div>
			<!-- Admin Heading Title End -->

			<!-- Transaction List -->
			<div class="transaction-area">

				@forelse ($transactions['data'] as $date => $transaction)

					@foreach ($transaction as $transact)
						<div class="items">
							<div href="javascript:;">
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
						</div>
					@endforeach

				@empty
					<show-empty-data-message />
				@endforelse
				
			</div>
			<!-- Transaction List End -->

			<div class="row mt-3 py-4">
				<div class="col text-center" >
				<a href="{{ routeWithLocale('customer.transactions') }}" class="btn btn-default">{{ translate(557) }}
						<i class="fas fa-chevron-right"></i>
					</a>    
				</div>
			</div>

		</div>
		<!-- All Transactions End -->
	</div>
@stop