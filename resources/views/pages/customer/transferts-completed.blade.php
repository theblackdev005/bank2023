@extends('layouts.customer')

@section('content')
	<div class="col-lg-9">
		<div class="profile-content">
			<h3 class="admin-heading">{{ translate(409) }} {{ $last_completed_transfert->reference }}</h3>
			
			<x-transfer-nav-pills step="3" />

			<div class="tab-content" id="pills-tabContent">
				<div class="tab-pane fade show active" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
					<div class="bg-offwhite success form">
						<div class="text-center">
							@livewire('transfer-count-down', [
								'loadsection' => $loadsection,
							])

							<hr>

							<h1 class=""><i class="far fa-check-circle text-success"></i></h1>
							<h3 class="text-success">{{ translate(551) }} !</h3>
							
							<p>{!! sprintf(translate(506), "<strong class='text-success'>". setCurrency($last_completed_transfert->currency, $last_completed_transfert->amount) ."</strong>") !!}</p>
							
							<p class="pt-2 m-0">
								<span class="name"><b>{{ translate(552) }}:</b></span>
								<span class="decs">#{{ $last_completed_transfert->reference }}</span>
							</p>
							<p class="m-0"><strong>{{ translate(511) }}</strong></p>

							<hr>

							<div class="invoice-option text-center mt-2 mb-3">
								<a href="{{ routeWithLocale('customer.download_transferts', $last_completed_transfert->reference) }}" class="invoice-btn"><i class="far fa-file-pdf"></i>{{ translate(515) }}</a>
							</div>
							
							<a href="javascript:;" data-toggle="modal" data-target="#my-modalBox__manager_contact_form" class="btn btn-primary hover mt-4 radius-50px"><i class="fa fa-envelope"></i> {{ translate(550) }}</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection