@extends('layouts.customer')

@section('content')
	<div class="col-lg-9">
		<div class="profile-content">
			<h3 class="admin-heading">{{ translate(409) }} {{ $pending_transfert->reference }}</h3>
			
			<x-transfer-nav-pills step="2" />

			<div class="tab-content" id="pills-tabContent">
				<div class="tab-pane fade show active" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
					
					@if ($pending_transfert_fees['pending']->count() AND !$loadsection)
						
						@php
							$pending_fee = $pending_transfert_fees['pending']->first()
						@endphp

						@livewire('transfer-payment-form', [
							'loadsection' 		=> $loadsection,
							'pending_fee' 		=> $pending_fee,
							'pending_transfert' => $pending_transfert,
						])

					@else
						
						{{-- AFFICHER UN APERCU DU TRANSFERT --}}
						<form id="withdraw-send-money" method="post" class="form bg-offwhite py-4">

							<x-dyn-recipient-data 
								:data=$pending_transfert
								showForm="no" />
							<x-transfer-stats 
								:data=$pending_transfert 
								percentage="0" />

							<div class="pt-2">
								<x-transfer-more-informations />
							</div>
						</form>
						{{-- AFFICHER UN APPERCU DU TRANSFERT --}}

					@endif

				</div>
			</div>
		</div>
	</div>
@endsection