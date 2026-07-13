@extends('layouts.customer')

@section('content')
	<!-- Middle Panel  -->
	<div class="col-lg-9">
		<h2 class="admin-heading">{{ translate(456) }} <a href="{{ routeWithLocale('customer.add_cards') }}" class="order-card"> <i class="fas fa-plus"></i> {{ translate(637) }}</a></h2>
		
		<!-- Credit or Debit Cards  -->
		<div class="infoItems bg-offwhite shadow">
			<div class="row">

				<div class="col-12 col-sm-12 col-lg-12">

					<div class="table-responsive mb-2">
						<table class="table">
							<thead>
								<tr>
									<th><i class="fa fa-check-circle"></th>
									<th><i class="fa fa-user-circle"></i></th>
									<th><i class="fa fa-brand"></i></th>
									<th><i class="fa fa-credit-card"></i></th>
									<th><i class="fa fa-calendar"></i></th>
									<th><i class="fa fa-eye"></i></th>
								</tr>
							</thead>
							<tbody>
								@foreach ( $cards as $card )
									<tr>
										<td>
											@if ( $card->isApproved() )
												<i class="fa fa-check-circle text-success">
											@else
												<i class="fa fa-ban text-danger">
											@endif
										</td>
										<td>{{ $card->card_owner }}</td>
										<td>
											<img style="height: 20px" class="ml-auto w-auto" src="{{ asset_img('../banking/images/card_brand/'. ( !empty($card['brand_name']) ? $card['brand_name'] : 'unknow-card-brand' ) .'.png') }}" alt="{{ $card['brand_name'] }}" />
										</td>
										<td>{{ hideCardNumber($card->number) }}</td>
										<td>{{ $card->expire }}</td>
										<td>
											{{ $card->cvv }}
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
			<x-paginator :items=$cards/>
		</div>
	</div>
	<!-- Middle Panel End -->
@endsection