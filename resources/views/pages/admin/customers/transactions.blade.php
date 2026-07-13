@extends('layouts.admin')

@section('content')
	<section class="container-section">
		<div class="container">
			<div class="row">
				
				<div class="col-md-12 bg-white p-4 table-responsive">
					<h1 class="mb-5">
					    <span>Transactions effectuées - </span>
					    <span class="badge bg-secondary text-white">{{ $customer->fullname() }}</span>
					</h1>

					<table class="table">
						<thead>
							<tr>
								<th>#</th>
								<th>DB/CD</th>
								<th>Coûts</th>
								<th>Solde</th>
								<th>Description</th>
								<th>Date</th>
								<th>Supprimer</th>
							</tr>
						</thead>
						<tbody>
							@php
								extract($transactions)
							@endphp

							@forelse ($data as $at => $transactions)
								
								<tr>
									<td colspan="7">
										<span class="badge bg-info text-white">
											<i class="fa fa-clock"></i>
											<span>{{ $at }}</span>
										</span>
									</td>
								</tr>

								@foreach ($transactions as $transaction)
									<tr>
										<td class="font-weight-bold">#{{ $transaction->uniqid }}</td>
										<td>
											<span class="badge text-white bg-{{ $transaction->type_html_clx }}">
												{{ translate($transaction->type_str) }}
											</span>
										</td>
										<td class="font-weight-bold">{{ setCurrency($transaction->currency, $transaction->cost) }}</td>
										<td class="font-weight-bold">{{ setCurrency($transaction->currency, $transaction->balance_after) }}</td>
										<td>{{ translate($transaction->description) }}</td>
										<td>
											<span>{{ dateFormat($transaction->created_at) }}</span><br>
											<span>{{ dateFormat($transaction->created_at, 2) }}</span>
										</td>
										<td>
											<a href="{{ routeWithLocale('admin.delete_transaction', ['username' => $customer->username, 'uniqid' => $transaction->uniqid]) }}" class="btn btn-danger btn-xs font-weight-bold" data-message="Êtes-vous certains de vouloir supprimer cette transaction ?">
												<i class="fa fa-remove mr-1"></i>
												<span>Supp.</span>
											</a>
										</td>
									</tr>
								@endforeach

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
				    <x-paginator :items=$pagination_data />
				</div>

			</div>
		</div>
	</section>
@endsection