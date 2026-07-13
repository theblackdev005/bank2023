@extends('layouts.customer')

@section('content')
	<div class="col-lg-9">
		<h2 class="admin-heading">{{ translate(339) }}</h2>
		<!-- Credit or Debit Cards  -->
		<div class="infoItems bg-offwhite">
			<div class="row">
				
				<div class="col-12 col-sm-12 col-lg-12">

					@forelse ($loans as $klh => $loan)
						<div class="table-responsive bg-white px-2 mb-4">
							<table class="table">
								<thead>
									<tr>
										<th>#</th>
										<th>{{ translate(340) }}</th>
										<th>{{ translate(341) }}</th>
										<th>{{ translate(342) }}</th>
										<th>{{ translate(343) }}</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td colspan="5">
											<strong class="badge text-white bg-{{ $loan->isApproved() ? 'success' : 'danger' }}">
												<i class="fa fa-calendar mr-1"></i>{{ dateFormat($loan->created_at) }}
											</strong>
										</td>
									</tr>
									<tr>
										<td class="text-bold">#{{ $loan->uniqid }}</td>
										<td>{{ setCurrency($loan->currency, $loan->amount) }}</td>
										<td>{{ $loan->duration }} {{ translate(344) }}</td>
										<td>
											@if ($loan->isApproved())
												{{ $loan->teag . "%" }}
											@else
												<i class='fa fa-remove text-danger'></i>
											@endif
										</td>
										<td>
											@if ($loan->isApproved())
												<span class="text-success font-weight-bold">{{ setCurrency($loan->currency, $loan->monthly_payment) }}</span>
											@else
												<i class='fa fa-remove text-danger'></i>
											@endif
										</td>
									</tr>
									<tr>
										<td colspan="5">
											<span class="text-bold text-block">{{ translate(345) }}</span>
											<blockquote class="text-block text-muted">{{ $loan->goal }}</blockquote>
										</td>
									</tr>
									<tr>
										<td class="bold">{{ translate(348) }}</td>
										<td colspan="4" class="text-success">
											@if ($loan->isApproved())
												<i class='fa fa-check text-success'></i>
											@else
												<strong class='text-danger'>
													{{ translate(363) }}
													<span class='points'></span>
												</strong>
											@endif
										</td>
									</tr>
									<tr>
										<td class="bold">{{ translate(860) }}</td>
										<td colspan="4">
											<span class="text-success">
												@if ( $loan->isApproved() )
													{{ dateFormat($loan->start_at, 1) }}
												@else
													<i class='fa fa-remove text-danger'></i>
												@endif
											</span>
										</td>
									</tr>
									<tr>
										<td colspan="3" class="text-right">{{ translate(350) }}</td>
										<td title="{{ translate(108) }}" class="text-bold text-success">
											@if ($loan->isApproved())
												{{ setCurrency($loan->currency, $loan->total_interest) }}
											@else
												<i class='fa fa-remove text-danger'></i>
											@endif
										</td>
										<td title="{{ translate(107) }}" class="text-bold text-success">
											@if ($loan->isApproved())
												{{ setCurrency($loan->currency, $loan->total_mpayment) }}
											@else
												<i class='fa fa-remove text-danger'></i>
											@endif
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					@empty
						<show-empty-data-message />
					@endforelse

				</div>
				
			</div>

		</div>
		<div class="mt-2">
			<x-paginator :items=$loans />
		</div>
	</div>
@endsection