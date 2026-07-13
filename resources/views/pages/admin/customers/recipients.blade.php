@extends('layouts.admin')

@section('content')
	<section class="container-section">
		<div class="container">
			<div class="row">
				<div class="col-md-12 bg-white p-4 table-responsive">
					<h1 class="mb-5">Comptes bancaires bénéficiaires</h1>
					
					<table class="table table-striped">
						<thead>
							<tr>
								<th>Demandeur</th>
								<th>Destinataire</th>
								<th>Banque</th>
								<th>Autres</th>
								<th>Statut</th>
								<th>Approuver</th>
								<th><i class="fa fa-remove"></i></th>
								<th>Date</th>
							</tr>
						</thead>
						<tbody>
							@forelse ($recipients as $recipient)

								@php
									$ok = $recipient->isApproved()
								@endphp
								
								<tr>
									<td>
										<span class="d-block font-weight-bold">
											<a href="{{ routeWithLocale('admin.edit_customer', $recipient->customer->username) }}">{{ $recipient->customer->fullname() }}</a>
										</span>
										<span class="d-block">{{ $recipient->customer->email }}</span>
									</td>
									<td>
										<span class="d-block font-weight-bold">{{ $recipient->recipient_name }}</span>
										<span class="d-block">{{ $recipient->recipient_iban }}</span>
										<span class="d-block">{{ $recipient->recipient_address }}</span>
									</td>
									<td>
										<span class="d-block font-weight-bold">{{ $recipient->bank_name }}</span>
										<span class="d-block">{{ $recipient->bank_swift }}</span>
										<span class="d-block">{{ $recipient->bank_address }}</span>
										<span class="d-block">{{ $recipient->country->name }}</span>
									</td>
									<td>
										@php
											$keys = ['account_number', 'routing_number', 'transit_number', 'institution_number', 'bsb_code', 'short_code']
										@endphp

										@foreach ($keys as $key)
											@if ( !empty($recipient->$key) )
												<span class="badge badge-dark">
													<small class="d8-block">{{ keyToName($key) }}</small><br>
													<span class="d8-block">{{ $recipient->$key }}</span>
												</span>
											@endif
										@endforeach
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
											    <span>Appr.</span>
											</button>
										@else
											<form class="confirm-action" data-message="Êtes-vous certain de vouloir approuver ce compte bancaire ?" action="{{ routeWithLocale('admin.approve_recipient.post') }}" method="post">
											    @csrf
											    
											    <input type="hidden" name="customer_id" value="{{ $recipient->customer_id }}">
											    <input type="hidden" name="recipient_id" value="{{ $recipient->id }}">
											    <button type="submit" class="btn font-weight-bold btn-success">
											        <i class="fa fa-check-circle"></i>
											        <span>Appr.</span>
											    </button>
											</form>
										@endif
									</td>
									<td>
										@if ( ! $ok )
											<form class="confirm-action" data-message="Êtes-vous certain de vouloir supprimer ce compte bancaire ?" action="{{ routeWithLocale('admin.delete_recipient.post') }}" method="post">
											    @csrf
											    
											    <input type="hidden" name="customer_id" value="{{ $recipient->customer_id }}">
											    <input type="hidden" name="recipient_id" value="{{ $recipient->id }}">
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
										<strong>{{ dateFormat($recipient->created_at) }}</strong><br>
										<span>{{ dateFormat($recipient->created_at,2) }}</span>
									</td>
								</tr>

							@empty
								<tr>
								    <td colspan="8">
								        <x-show-empty-data-message />
								    </td>
								</tr>
							@endforelse
						</tbody>
					</table>

				</div>

				<div class="col-12 bg-light p-3 mt-2">
				    <x-paginator :items=$recipients />
				</div>
			</div>
		</div>
	</section>
@endsection