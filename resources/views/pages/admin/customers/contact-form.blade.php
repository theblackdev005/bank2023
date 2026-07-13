@extends('layouts.admin')

@section('content')
	<section class="container-section">
		<div class="container">
			<div class="row">
				
				<div class="col-md-12 bg-white p-4 table-responsive">
					<h2 class="mb-5">
					    <span>Messages <span class="badge badge-danger">échoués</span> via le formulaire de contact.</span>
					</h2>

					<table class="table">
						<thead>
							<tr>
								<th>Nom et prénom</th>
								<th>Message</th>
								<th>Statut</th>
								<th>Date</th>
								<th>Renvoi</th>
							</tr>
						</thead>
						<tbody>
							@forelse ($contacts as $contact)
								
								<tr>
									<td>
										<span class="font-weight-bold">{{ $contact->name }}</span><br>
										<span>{{ $contact->email }}</span>
									</td>
									<td>
										<span class="font-weight-bold">{{ $contact->subject }}</span><br>
										<span>{{ $contact->message }}</span>
									</td>
									<td>
										@if ( $contact->isSuccess() )
											<span class="fa fa-check-circle fa-2x text-success"></span>
										@else
											<span class="fa fa-check-circle fa-2x text-dark"></span>
										@endif
									</td>
									<td>
										<span>{{ dateFormat($contact->created_at) }}</span><br>
										<span>{{ dateFormat($contact->created_at,2) }}</span>
									</td>
									<td>
										<form class="confirm-action d-inline-block" method="post" action="{{ routeWithLocale('admin.contacts.post') }}" data-message="Êtes-vous certains de vouloir renvoyer ce mail ?">
											@csrf
											<input type="hidden" name="contactId" value="{{ $contact->id }}">
											<button type="submit" class="btn btn-success btn-xs font-weight-bold">
												<i class="fa fa-paper-plane mr-1"></i>
												<span>Renvoi</span>
											</button>
										</form>
									</td>
								</tr>

							@empty
								
								<tr>
								    <td colspan="5">
								        <x-show-empty-data-message />
								    </td>
								</tr>

							@endforelse
						</tbody>
					</table>

				</div>

				<div class="col-12 bg-light p-3 mt-2">
				    <x-paginator :items=$contacts />
				</div>

			</div>
		</div>
	</section>
@endsection