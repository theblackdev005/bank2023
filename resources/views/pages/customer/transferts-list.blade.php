@extends('layouts.customer')

@section('content')
	<div class="col-lg-9">
		<h2 class="admin-heading">{{ translate(632) }}</h2>
		<!-- Credit or Debit Cards  -->
		<div class="infoItems bg-offwhite">
			<div class="row">
				
				<div class="col-12 col-sm-12 col-lg-12">
					<div class="table-responsive">
						<table class="table table-striped">
							<thead>
								<tr>
									<th>#</th>
									<th>{{ translate(340) }}</th>
									<th><span class="fa fa-check-circle text-secondary"></span></th>
									<th>{{ translate(103) }}</th>
									<th>#</th>
								</tr>
							</thead>
							<tbody>
								@forelse ($transfers as $transfert)
									<tr>
										<td>{{ $transfert->reference }}</td>
										<td>
											<span class="badge badge-success text-white">{{ setCurrency( $transfert->currency, $transfert->amount) }}</span>
										</td>
										<td>
											@if ($transfert->isCompleted())
												<span class="fa fa-check-circle text-success"></span>
											@else
												<span class="fa fa-check-circle blink text-warning"></span>
											@endif
										</td>
										<td>
											@foreach (dyn_recipient_data($transfert) as $translation_key => $value)
												<span class="text-right">{{ translate($translation_key) }}:</span>
												<strong class="text-left">{{ $value }}</strong><br>
											@endforeach
										</td>
										<td>
											<i class="fas fa-file-pdf cursor-pointer" onclick="window.location.href='{{ routeWithLocale('customer.download_transferts', $transfert->reference) }}'"></i>
										</td>
									</tr>
								@empty
									{{-- empty expr --}}
								@endforelse

							</tbody>
						</table>
					</div>
				</div>
				
			</div>
		</div>
	</div>
@endsection