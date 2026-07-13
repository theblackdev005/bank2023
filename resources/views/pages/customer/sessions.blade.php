@extends('layouts.customer')

@section('content')
	<div class="col-lg-9">
		<h2 class="admin-heading">{{ translate(364) }}</h2>
		<!-- Credit or Debit Cards  -->
		<div class="infoItems bg-offwhite">
			<div class="row">
				
				<div class="col-12 col-sm-12 col-lg-12">
					<div class="table-responsive">
						<table class="table table-striped">
							@if ( $sessions )
								
								<thead>
									<tr>
										<th></th>
										<th>{{ translate(365) }}</th>
										<th></th>
									</tr>
								</thead>
								<tbody>
									@foreach ( $sessions as $key=>$session )
										<tr>
											<td class="text-{{ ($session->isActive()) ? 'success' : 'secondary' }}">
												<i class="fa fa-globe fz-5"></i>
											</td>
											<td>
												<div>{{ translate(366) }}: {{ dateFormat($session->last_seen_at) }}</div>
												<div>{{ $session->user_agent }}</div>
												<div>
													<strong class="badge bg-info text-light">{{ $session->ip_address }}</strong>
												</div>
											</td>
											<td>
												<div>
													<div class="text-small">{{ translate(367) }}</div>
													<div onclick="window.location.href='{{ routeWithLocale('customer.sessions', ['sessid' => $session->id]) }}'" class="btn btn-danger btn-xs cursor-pointer">{{ translate(368) }}</div>
												</div>
											</td>
										</tr>
									@endforeach
								</tbody>

							@endif

						</table>
					</div>

				</div>
				
			</div>
		</div>
		<div class="pt-2">
			<x-paginator :items=$sessions/>
		</div>
	</div>
@endsection