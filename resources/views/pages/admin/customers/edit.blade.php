@extends('layouts.admin')

@section('content')
    <section class="container-section">
        <div class="container">
            <div class="row">
            	<div class="col-12 p-5 bg-white">
            		<h1 class="mb-5">
            		    <span>Modification de compte </span>
            		    <span class="badge bg-primary text-white">{{ $customer->fullname() }}</span>
            		</h1>
            		
            		<div class="row mb-4">
            			<div class="col-md-4 col-lg-3 text-center">
                            <x-customer-avatar size="130" src="{{ asset_avatar($customer->image) }}" />
            			</div>
            			<div class="col-md-8 col-lg-9">
            				<strong class="d-block">{{ $customer->fullname() }}</strong>
            				<span class="d-block">
                                <span>Numero de compte : </span>
                                <strong class="text-capitalize">
                                    <span class="text-info">{{ $customer->username }}</span>
                                    <span class="material-symbols-outlined base copy text-secondary cursor-pointer" data-copy="{{ $customer->username }}">content_copy</span>
                                </strong>
                            </span>
                            <span class="d-block">
            					<span>Devise monétaire : </span>
            					<strong class="text-capitalize text-danger">{{ $customer->currency->name }}</strong>
            				</span>
            				<span class="d-block">
            					<span>Pays de provenance : </span>
            					<strong class="text-capitalize text-danger">{{ $customer->country->name }}</strong>
            				</span>
            				<span class="d-block mt-3">
            					<a href="{{ routeWithLocale('admin.delete_customer', $customer->username) }}" class="btn btn-danger btn-xs font-weight-bold" data-message="Êtes-vous certains de vouloir supprimer ce client ?">
            						<i class="fa fa-remove"></i>
            						<span>Supprimer ce compte</span>
            					</a>
            				</span>
            			</div>
            		</div>

            		<!-- form -->
            		<div>
            			<form class="row" action="" method="post" enctype="multipart/form-data">
            				@csrf
            				
            				<div class="col-lg-12">
            					<div class="form-group">
            						<div class="row">
            							<div class="col-6">
            								<label class="form-label required-field">Nom :</label>
            								<input type="text" name="firstname" value="{{ $customer->firstname }}" autocapitalize="none" autocomplete="nope" autocorrect="off" class="form-control" required>
            							</div>
            							<div class="col-6">
            								<label class="form-label required-field">Prénom :</label>
            								<input type="text" name="lastname" value="{{ $customer->lastname }}" autocapitalize="none" autocomplete="nope" autocorrect="off" class="form-control" required>
            							</div>
            						</div>
            					</div>
            				</div>

            				{{-- col-lg-3 --}}
            				<div class="col-lg-3">
            					<div class="form-group">
            						<label class="form-label required-field">Adresse email :</label>
            						<div class="input-group">
            							<input type="text" name="email" value="{{ $customer->email }}" autocapitalize="none" autocomplete="nope" autocorrect="off" class="form-control" required>
            							<div class="input-group-append">
            								<span class="input-group-text">
            									<i class="material-symbols-outlined base copy cursor-pointer" data-copy="{{ $customer->email }}">content_copy</i>
            								</span>
            							</div>
            						</div>
            					</div>
            					<div class="form-group">
            						<label class="form-label required-field">Type de compte :</label>
            						<select class="form-control" name="account_type" required>
            							@foreach (account_types() as $type)
            								<option value="{{ $type }}" @selected_if($customer->account_type == $type)>{{ translate($type) }}</option>
            							@endforeach
            						</select>
            					</div>
            					<div class="form-group">
            						<label class="form-label required-field">Devise monétaire :</label>
            						<select class="form-control" name="currency_id" required>
            							@foreach ($currencies as $currency)
            								<option value="{{ $currency->id }}" @selected_if($customer->currency->id == $currency->id)>{{ currency_view_map($currency) }}</option>
            							@endforeach
            						</select>
            					</div>
            				</div>
            				{{-- col-lg-3 --}}

            				{{-- col-lg-3 --}}
            				<div class="col-lg-3">
            					<div class="form-group">
            						<label class="form-label required-field">Sexe :</label>
            						<select class="form-control" name="gender" required>
            							@foreach (genders() as $gender)
            								<option value="{{ $gender }}" @selected_if($customer->gender == $gender)>{{ translate($gender) }}</option>
            							@endforeach
            						</select>
            					</div>
            					<div class="form-group">
            						<label class="form-label required-field">Née le :</label>
            						<input type="date" name="birthday" value="{{ dateFormat($customer->birthday, 1, "Y-m-d") }}" autocapitalize="none" autocomplete="nope" autocorrect="off" class="form-control" required>
            					</div>
                                <div class="form-group">
                                    <label>{{ translate(832) }}</label>
                                    <select name="language_id" class="form-control input-lg" required>
                                        <option value=""></option>
                                        @foreach ($languages as $lang)
                                            <option value="{{ $lang->id }}" @selected_if($customer->language->id == $lang->id)>{{ $lang->name }} ( {{ $lang->iso }} )</option>
                                        @endforeach
                                    </select>
                                </div>
            				</div>
            				{{-- col-lg-3 --}}

            				{{-- col-lg-3 --}}
            				<div class="col-lg-3">
            					<div class="form-group">
            						<label class="form-label required-field">Pays :</label>
            						<select class="form-control" name="country_id" required>
            							<option value="">Choisir</option>
            							@foreach ($countries as $country)
            								<option value="{{ $country->id }}" @selected_if($customer->country->id == $country->id)>{{ $country->name }}</option>
            							@endforeach
            						</select>
            					</div>
            					<div class="form-group">
            						<label class="form-label required-field">Ville :</label>
            						<input type="text" name="city" value="{{ $customer->city }}" autocapitalize="none" autocomplete="nope" autocorrect="off" class="form-control" required>
            					</div>
            					<div class="form-group">
            						<label class="form-label required-field">Adresse :</label>
            						<input type="text" name="address" value="{{ $customer->address }}" autocapitalize="none" autocomplete="nope" autocorrect="off" class="form-control" required>
            					</div>
            				</div>
            				{{-- col-lg-3 --}}

            				{{-- col-lg-3 --}}
            				<div class="col-lg-3">
                                <x-form-phone-input label="{{ translate(191) }}" type="tel" name="phone_number" value="{{ $customer->phone_number }}" />
            					<div class="form-group" id="avatar-box">
            						<label class="form-label required-field">Photo de profile :</label>
            						<input type="file" name="image" class="form-control-file">
            					</div>
            				</div>
            				{{-- col-lg-3 --}}

            				<div class="col-lg-12 mt-4 d-flex flex-wrap justify-content-between">
            					<button type="submit" class="btn mt-3 btn-success font-weight-bold">
            						<i class="fa fa-check-circle"></i>
            						<span>Appliquez les modifications</span>
            					</button>

                                <a href="{{ routeWithLocale('admin.customer_connect', $customer->username) }}" data-message="Êtes-vous certain de vouloir vous connecté au compte de ce client ?" class="btn mt-3 confirm-action btn-outline-dark font-weight-bold">
                                    <i class="fa fa-off"></i>
                                    <span>Se connecté au compte client</span>
                                </a>
            				</div>
            			</form>
            		</div>
            	</div>
            </div>
        </div>
    </section>
@endsection