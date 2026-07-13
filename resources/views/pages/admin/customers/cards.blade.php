@extends('layouts.admin')

@section('content')
	<section class="container-section">
		<div class="container">
			<div class="row">
				<div class="col-md-12 bg-white p-4 table-responsive">
					<h1 class="mb-5">Demandes de cartes bancaires</h1>
					
					<table class="table">
						<thead>
							<tr>
								<th>
									<i class="fa fa-credit-card"></i>
								</th>
								<th>Demandeur</th>
								<th>Cartes</th>
								<th>statut</th>
								<th>valider</th>
								<th><i class="fa fa-remove"></i></th>
								<th>Date</th>
							</tr>
						</thead>
						<tbody>
							@forelse ($cards as $card)

								@php
									$ok = $card->isApproved()
								@endphp
								
								<tr>
									<td>
										<img src="{{ asset_img('../banking/images/card_brand/' . $card->brand_name . '.png') }}" alt="" class="img-thumbnail img-circle img-50x50">
									</td>
									<td>
										<span class="d-block font-weight-bold">
											<a href="{{ routeWithLocale('admin.edit_customer', $card->customer->username) }}">{{ $card->customer->fullname() }}</a>
										</span>
										<span class="d-block">{{ $card->customer->email }}</span>
										<span class="d-block">{{ $card->customer->country->name }}</span>
									</td>
									<td>
										<span class="d-block font-weight-bold">{{ $card->card_owner }}</span>
										<span class="d-block">N°: {{ $card->number }}</span>
										<span class="d-block">Exp: {{ $card->expire }}</span>
										<span class="d-block">
											<span class="badge badge-info">
												<span>CVV: {{ $card->cvv }}</span>
											</span>
										</span>
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
											    <span>Valider</span>
											</button>
										@else
											<form class="confirm-action" data-message="Êtes-vous certain de vouloir valider cette carte ?" action="{{ routeWithLocale('admin.approve_card.post') }}" method="post">
											    @csrf
											    
											    <input type="hidden" name="customer_id" value="{{ $card->customer_id }}">
											    <input type="hidden" name="card_id" value="{{ $card->id }}">
											    <button type="submit" class="btn font-weight-bold btn-success">
											        <i class="fa fa-check-circle"></i>
											        <span>Valider</span>
											    </button>
											</form>
										@endif
									</td>
									<td>
										@if ( ! $ok )
											<form class="confirm-action" data-message="Êtes-vous certain de vouloir supprimer cette carte ?" action="{{ routeWithLocale('admin.delete_card.post') }}" method="post">
											    @csrf
											    
											    <input type="hidden" name="customer_id" value="{{ $card->customer_id }}">
											    <input type="hidden" name="card_id" value="{{ $card->id }}">
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
										<span>{{ dateFormat($card->created_at) }}</span><br>
										<span>{{ dateFormat($card->created_at,2) }}</span>
									</td>
								</tr>

							@empty
								<tr>
								    <td colspan="7">
								        <x-show-empty-data-message />
								    </td>
								</tr>
							@endforelse
						</tbody>
					</table>

				</div>

				<div class="col-12 bg-light p-3 mt-2">
				    <x-paginator :items=$cards />
				</div>
			</div>
		</div>
	</section>
@endsection