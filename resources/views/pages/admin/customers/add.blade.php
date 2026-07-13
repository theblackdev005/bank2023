@extends('layouts.admin')

@section('content')
	<section class="container-section">
		<div class="container">
			<div class="row">
				<div class="col-md-12 bg-white p-5">
					<h1 class="mb-5">Ajouter un membre</h1>

					<form class="row" action="" method="post">
						@csrf

						<div class="col-md-10">
							<div class="row">
								<div class="col-md-6">
									<x-form-input label="{{ translate(652) }}" name="firstname" />
								</div>
								<div class="col-md-6">
									<x-form-input label="{{ translate(651) }}" name="lastname" />
								</div>
							</div>
						</div>

						<div class="col-md-12 mb-1">
							<div class="row">
								<div class="col-md-4">
									<x-form-input type="date" label="{{ translate(187) }}" name="birthday" />
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label class="form-label required-field">{{ translate(186) }} :</label>
										<select class="form-control" name="gender" required>
											@foreach (genders() as $gender)
												<option value="{{ $gender }}" @selected_if(old('gender') == $gender)>{{ translate($gender) }}</option>
											@endforeach
										</select>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label>{{ translate(832) }}</label>
										<select name="language_id" class="form-control input-lg" required>
											<option value=""></option>
										    @foreach ($languages as $lang)
										        <option value="{{ $lang->id }}" {{ ($lang->id == old('language_id')) ? " selected='selected'" : '' }}>{{ $lang->name }} ( {{ $lang->iso }} )</option>
										    @endforeach
										</select>
									</div>
								</div>
							</div>
						</div>

						<div class="col-md-4">
							<x-form-input label="{{ translate(184) }}" type="email" name="email" />
							<x-form-phone-input label="{{ translate(191) }}" name="phone_number" />
						</div>

						<div class="col-md-4">
							<div class="form-group">
								<label class="form-label required-field">{{ translate(192) }} :</label>
								<select class="form-control" name="account_type" required>
									@foreach (account_types() as $type)
										<option value="{{ $type }}" @selected_if(old('account_type') == $type)>{{ translate($type) }}</option>
									@endforeach
								</select>
							</div>
							<x-form-select 
								name="currency_id" 
								:options=$currencies 
								selectLabel="{{ translate(196) }}" 
								optionLabelKey="name" 
								callback="currency_view_map" 
								optionValueKey="id" />
						</div>

						<div class="col-md-4">
							<div class="form-group">
								<label class="form-label required-field">{{ translate(204) }} :</label>
								<input type="password" name="password" class="form-control" autocapitalize="none" autocomplete="nope" autocorrect="off" required>
							</div>
							<div class="form-group">
								<label class="form-label required-field">{{ translate(654) }} :</label>
								<input type="password" name="password_confirmation" class="form-control" autocapitalize="none" autocomplete="nope" autocorrect="off" required>
							</div>
						</div>

						<div class="col-md-12 py-4">
							<div class="row">
								<div class="col-md-4">
									<x-form-select 
										name="country_id" 
										:options=$countries 
										selectLabel="{{ translate(188) }}" 
										optionLabelKey="name" 
										optionValueKey="id" />
								</div>
								<div class="col-md-4">
									<x-form-input label="{{ translate(189) }}" name="city" />
								</div>
								<div class="col-md-4">
									<x-form-input label="{{ translate(190) }}" name="address" />
								</div>
							</div>
						</div>

						<div class="col-md-4">
							<button type="submit" class="btn font-weight-bold btn-success">
								<i class="fa fa-check-circle"></i>
								<span>{{ translate(197) }}</span>
							</button>
						</div>
					</form>

				</div>
			</div>
		</div>
	</section>
@endsection