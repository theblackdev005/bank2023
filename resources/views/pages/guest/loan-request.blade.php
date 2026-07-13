@extends('layouts.guest')

@section('content')
	<div class="service-area bg-light py-5" style="padding-bottom: 150px;">
		<div class="container pb-3">
			<div class="row">

				<div class="col-12">
					<h2>{{ translate(339) }}</h2>
					<p>{{ translate(589) }}</p>
				</div>

				<form action="{{ routeWithLocale('guest.loan_request.post') }}" class="col-12" method="POST">
					@csrf

					<x-alert></x-alert>
					<hr>

					<div class="row d-flex flex-wrap-reverse">
						<div class="col-xl-7 col-lg-7">
							<div class="pb-3">
								
								<div>
									<div class="alert alert-info mb-4">
										<p>{{ translate(347) }}</p>
									</div>
									<div class="tab-- mb-5">
									    <div class="form-group">
									    	<div class="row">
									    		<div class="col-lg-6 col-md-6">
									    			<x-form-input
									    				type="text" 
									    				name="prenom" 
									    				label="{{ translate(652) }}"/>
									    		</div>
									    		<div class="col-lg-6 col-md-6">
									    			<x-form-input
									    				type="text" 
									    				name="nom" 
									    				label="{{ translate(651) }}"/>
									    		</div>
									    	</div>
									    </div>

									    <div class="form-group">
									    	<div class="row">
									    		<div class="col-xs-8 col-md-8">
												    <x-form-input
												    	type="email" 
												    	name="adresse_email" 
												    	label="{{ translate(184) }}"/>
												</div>
											</div>
										</div>

									    <div class="form-group">
									    	<div class="row">
									    		<div class="col-xs-5 col-md-5">
									    			<label class="form-label required-field">{{ translate(186) }} :</label>
									    			<select class="form-control" name="sexe" required>
									    				@foreach (genders() as $gender)
									    			    	<option value="{{ $gender }}">{{ translate($gender) }}</option>
									    				@endforeach
									    			</select>
									    		</div>
									    		<div class="col-xs-5 col-md-5">
									    			<x-form-phone-input label="{{ translate(191) }}" name="numero_telephone" />
									    		</div>
									    	</div>
									    </div>

									    <div class="form-group">
									    	<div class="row">
									    		<div class="col-lg-4">
									    			<x-form-select 
									    				name="pays_residence" 
									    				:options=$countries 
									    				selectLabel="{{ translate(188) }}" 
									    				optionLabelKey="name" 
									    				optionValueKey="id" />
									    		</div>
									    		<div class="col-lg-4">
									    			<x-form-input
									    				type="text" 
									    				name="region" 
									    				label="{{ translate(189) }}"/>
									    		</div>
									    		<div class="col-lg-4">
									    			<x-form-input
									    				type="text" 
									    				name="adresse_complete" 
									    				label="{{ translate(190) }}"/>
									    		</div>
									    	</div>
									    </div>

									</div>

								</div>

								<div class="d-flex mx-auto pt-2">
									<button type="submit" class="btn btn-lg btn-success">
										<i class="fa fa-check-circle"></i>
										<span>{{ translate(260) }}</span>
									</button>
								</div>

							</div>
						</div>
						<div class="col-xl-5 col-lg-5 bg-white mb-3 p-4 shadow-sm">
							@livewire('guest-loan-calculator', compact('currencies'))
						</div>
					</div>
				</form>

			</div>
		</div>
	</div>
@endsection