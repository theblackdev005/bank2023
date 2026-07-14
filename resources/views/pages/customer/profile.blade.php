@extends('layouts.customer')

@section('content')
	<!-- Middle Panel -->
	<div class="col-lg-9 profile-area">
		<h3 class="admin-heading bg-offwhite">
			<a onclick="window.location.href='{{ routeWithLocale('customer.edit_account') }}'" href="{{ routeWithLocale('customer.edit_account') }}" class="btn-link pbtn"><i class="fas fa-edit mr-1"></i>{{ translate(112) }}</a>
			<p>{{ translate(542) }}</p>
		</h3>

		<!-- Edit personal info End -->
		<div class="infoItems shadow p-mobile-0">
			<ul class="nav nav-tabs">
				<li><a data-toggle="tab" href="#menu1" class="active">{{ translate(542) }}</a></li>
				<li><a data-toggle="tab" href="#menu2">{{ translate(544) }}</a></li>
			</ul>

			<div class="tab-content">
				<div id="menu1" class="tab-pane fade in active">
					<div class="row">
						<p class="col-sm-3"><b>{{ translate(487) }}</b></p>
						<p class="col-sm-9">
							<span>{{ $customer->username }}</span><br>
							<a href="{{ routeWithLocale('customer.edit_account') }}">{{ translate(112) }}</a>
						</p>
					</div>
					<hr>
					<div class="row">
						<p class="col-sm-3"><b>{{ translate(182) }}</b></p>
						<p class="col-sm-9">{{ $customer->fullname() }}</p>
					</div>
					<hr>
					<div class="row">
						<p class="col-sm-3"><b>{{ translate(333) }}</b></p>
						<p class="col-sm-9">{{ dateFormat($customer->birthday, 1, "d/m/Y", null, false) }}</p>
					</div>
					<hr>
					<div class="row">
						<p class="col-sm-3"><b>{{ translate(186) }}</b></p>
						<p class="col-sm-9">{{ translate($customer->gender) }}</p>
					</div>
					<hr>
					<div class="row">
						<p class="col-sm-3"><b>{{ translate(543) }}</b></p>
						<p class="col-sm-9">
							<span class="text-success" data-toggle="tooltip" data-original-title="{{ translate(33) }}">
								<i class="fas fa-check-circle"></i>
								<span>{{ translate(33) }}</span>
							</span>
						</p>
					</div>
					<hr>
					<div class="row">
						<p class="col-sm-3">
							<b>{{ translate(191) }}</b> 
							<span class="text-muted font-weight-500">(*)</span>
						</p>
						<p class="col-sm-9">{{ $customer->phone_number }}</p>
					</div>
					<hr>
					<div class="row">
						<p class="col-sm-3"><b>{{ translate(190) }}</b></p>
						<p class="col-sm-9">
							<span>{{ $customer->address }} - {{ $customer->city }}</span><br>
							<strong>{{ $customer->country->name }}</strong>
						</p>
					</div>
				</div>
				<!-- END First Tab -->

				<div id="menu2" class="tab-pane fade">
					<div class="row">
						<p class="col-sm-3">
							<b>{{ translate(184) }}</b> 
							<span class="text-muted font-weight-500">(*)</span>
						</p>
						<div class="col-sm-9">
							<p class="mb-0">{{ $customer->email }} </p>
						</div>
					</div>
					<hr>
					<div class="row">
						<p class="col-sm-3"><b>{{ translate(192) }}</b></p>
						<p class="col-sm-9">
							<span>{{ translate($customer->account_type) }} ( <strong class="text-info">{{ $customer->currency->name }}</strong> )</span>
						</p>
					</div>
					<hr>
					<div class="row">
						<p class="col-sm-3"><b>{{ translate(185) }}</b></p>
						<p class="col-sm-9">
							<a href="{{ routeWithLocale('customer.edit_password') }}">{{ translate(113) }}</a>
						</p>
					</div>
				</div>

			</div>
		</div>
	</div>
	<!-- Middle Panel End -->
@endsection
