@extends('layouts.customer')

@section('content')
	<div class="col-lg-9">
		<div class="profile-content">
			<h3 class="admin-heading">{{ translate(409) }} {{ $pending_transfert->reference }}</h3>
			
			<x-transfer-nav-pills step="2" />

			<div class="tab-content" id="pills-tabContent">
				<div class="tab-pane fade show active" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
					
					<form id="withdraw-send-money" method="post" class="form bg-offwhite py-4">
						
						@if ($loadsection['init'])
							
							<x-dyn-recipient-data :data=$pending_transfert showForm="no" />
							<x-transfer-stats :data=$pending_transfert init="yes" percentage="0" />

						@else

							@if ( $fee = $pending_transfert->currentPayedFee() )
								
								<x-dyn-recipient-data :data=$pending_transfert code="{{ $fee->code }}" />
								<x-transfer-stats showNextPendingFee="no" :data=$pending_transfert percentage="{{ $fee->percentage }}" />
								<x-transfer-success-code :fee=$fee />

							@elseif( $fee = $pending_transfert->currentPendingFee() )
								
								<x-dyn-recipient-data :data=$pending_transfert showForm="{{ $loadsection ? 'no' : 'yes' }}" />
								<x-transfer-stats :data=$pending_transfert percentage="{{ $fee->percentage }}" />

							@else
								
								<x-dyn-recipient-data :data=$pending_transfert showForm="no" />
								<x-transfer-stats :data=$pending_transfert percentage="0" />

							@endif

						@endif

						<div class="pt-2">
							<x-transfer-more-informations />
						</div>
					</form>

				</div>
			</div>
		</div>
	</div>
@endsection