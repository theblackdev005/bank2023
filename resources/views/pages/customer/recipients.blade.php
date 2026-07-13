@extends('layouts.customer')

@section('content')
	<div class="col-lg-9">
		<h2 class="admin-heading">{{ translate(370) }} <a href="{{ routeWithLocale('customer.add_recipients') }}" class="order-card"> <i class="fas fa-plus"></i> {{ translate(104) }} </a></h2>
		<!-- Credit or Debit Cards  -->
		<div class="infoItems bg-offwhite">
			<div class="row">

				<div class="col-12 col-sm-12 col-lg-12">

					<div class="table-responsive mb-2">
						<table class="table table-striped">
							<thead>
								<tr>
									<th><i class="fa fa-check-circle"></th>
									<th><i class="fa fa-university"></i></th>
									<th><i class="fa fa-user-circle"></i></th>
									<th><i class="fa fa-calendar"></i></th>
								</tr>
							</thead>
							<tbody>
								@foreach ( $recipients as $nr => $recipient )
									<tr>
										<td>
											@if ( $recipient->isApproved() )
												<i class="fa fa-check-circle text-success">
											@else
												<i class="fa fa-ban text-danger">
											@endif
										</td>
										<td>
											<span class="badge bg-secondary text-white">{{ $recipient->bank_name }}</span><br>
											<span>{{ $recipient->bank_address }}</span><br>
											<strong>{{ $recipient->country->name }}</strong>
										</td>
										<td>
											<span class="badge bg-info text-white">{{ $recipient->recipient_name }}</span><br>
											<strong class="text-success">{{ showIbanOrAccountNumber($recipient) }} ({{ $recipient->currency->name }})</strong><br>
											<span>{{ $recipient->recipient_address }}</span>
										</td>
										<td>
											{{ dateFormat($recipient->created_at) }} <br>
											{{ dateFormat($recipient->created_at, 2) }}
										</td>
									</tr> 
								@endforeach
							</tbody>
						</table>
					</div>

				</div>
			</div>
		</div>

		<div class="mt-3">
			<x-paginator :items=$recipients/>
		</div>

	</div>
@endsection