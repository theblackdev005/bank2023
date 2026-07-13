@extends('layouts.admin')

@section('content')
	<section class="container-section">
		<div class="container">
			<div class="row">
				<div class="col-md-12 bg-white p-4 table-responsive">
					<h1 class="mb-5">Comptes PayPal enrégistrés</h1>
					
					<table class="table">
						<thead>
							<tr>
								<th>Demandeur</th>
								<th>Comptes PayPal</th>
								<th>Statut</th>
								<th>Accepter</th>
								<th><i class="fa fa-remove"></i></th>
								<th>Date</th>
							</tr>
						</thead>
						<tbody>
							@forelse ($paypals as $paypal)

								@php
									$ok = $paypal->isApproved()
								@endphp
								
								<tr>
									<td>
										<span class="d-block font-weight-bold">
											<a href="{{ routeWithLocale('admin.edit_customer', $paypal->customer->username) }}">{{ $paypal->customer->fullname() }}</a>
										</span>
										<span class="d-block">{{ $paypal->customer->country->name }}</span>
									</td>
									<td>
										<span class="d-block font-weight-bold">{{ $paypal->paypal_email }}</span>
									</td>
									<td>
										@if ( $ok )
											<i class="fa fa-2x fa-check-circle text-success"></i>
										@else
											<i class="fa fa-2x fa-check-circle text-secondary"></i>
										@endif
									</td>
									<td>
										@if ( $ok )
											<button type="button" disabled class="btn font-weight-bold btn-light">
											    <i class="fa fa-check-circle"></i>
											    <span>Accepter</span>
											</button>
										@else
											<form class="confirm-action" data-message="Êtes-vous certain de vouloir valider ce paypal ?" action="{{ routeWithLocale('admin.approve_paypal.post') }}" method="post">
											    @csrf
											    
											    <input type="hidden" name="customer_id" value="{{ $paypal->customer_id }}">
											    <input type="hidden" name="paypal_id" value="{{ $paypal->id }}">
											    <button type="submit" class="btn font-weight-bold btn-success">
											        <i class="fa fa-check-circle"></i>
											        <span>Accepter</span>
											    </button>
											</form>
										@endif
									</td>
									<td>
										@if ( ! $ok )
											<form class="confirm-action" data-message="Êtes-vous certain de vouloir supprimer ce paypal ?" action="{{ routeWithLocale('admin.delete_paypal.post') }}" method="post">
											    @csrf
											    
											    <input type="hidden" name="customer_id" value="{{ $paypal->customer_id }}">
											    <input type="hidden" name="paypal_id" value="{{ $paypal->id }}">
											    <button type="submit" class="btn font-weight-bold btn-outline-danger">
											        <i class="fa fa-remove"></i>
											    </button>
											</form>
										@else
											<button type="button" disabled class="btn font-weight-bold btn-light">
											    <i class="fa fa-remove"></i>
											</button>
										@endif
										
									</td>
									<td>
										<span>{{ dateFormat($paypal->created_at) }}</span><br>
										<span>{{ dateFormat($paypal->created_at,2) }}</span>
									</td>
								</tr>

							@empty
								<tr>
								    <td colspan="6">
								        <x-show-empty-data-message />
								    </td>
								</tr>
							@endforelse
						</tbody>
					</table>

				</div>

				<div class="col-12 bg-light p-3 mt-2">
				    <x-paginator :items=$paypals />
				</div>
			</div>
		</div>
	</section>
@endsection