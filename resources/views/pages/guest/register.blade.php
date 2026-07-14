@extends('layouts.guest')

@section('script')
	@if ( GOOGLE_RECAPTCHA_ENABLED )
		<script src="https://www.google.com/recaptcha/api.js" async defer></script>
	@endif
	<script>
		document.addEventListener('DOMContentLoaded', function () {
			const day = document.getElementById('birthday_day');
			const month = document.getElementById('birthday_month');
			const year = document.getElementById('birthday_year');
			const birthday = document.getElementById('birthday');

			if (!day || !month || !year || !birthday) return;

			const locale = document.documentElement.lang || 'fr';
			const monthFormatter = new Intl.DateTimeFormat(locale, { month: 'long' });
			Array.from(month.options).slice(1).forEach(function (option, index) {
				option.textContent = String(index + 1).padStart(2, '0') + ' - ' + monthFormatter.format(new Date(2020, index, 1));
			});

			function updateBirthday() {
				birthday.value = day.value && month.value && year.value
					? year.value + '-' + month.value.padStart(2, '0') + '-' + day.value.padStart(2, '0')
					: '';
			}

			[day, month, year].forEach(function (field) {
				field.addEventListener('change', updateBirthday);
			});
			updateBirthday();
		});
	</script>
@endsection

@section('content')
	<section class="two-partite shadow-none">
		<div class="container-fluid">
			<div class="row">
				<div class="col-lg-7 bg-light">
					<div class="bg-with-covered-image auth-pd">
						<form action="" method="POST" id="multi-step-form">
							@csrf
							
							<div class="section-title mb-5">
								<h1 class="title text-theme pm-0">{{ translate(181) }}</h1>
								<div>
									<p>{{ translate(291) }}</p>
								</div>
							</div>

							<div class="py-2 d-none" id="step-box">
								<span class="step"></span>
								<span class="step"></span>
							</div>

							<x-alert />

						    <div class="tab">
						        <div class="form-group">
						        	<div class="row">
						        		<div class="col-xs-12 col-lg-6 col-md-6">
						        			<x-form-input name="firstname" label="{{ translate(652) }}" />
						        		</div>
						        		<div class="col-xs-12 col-lg-6 col-md-6">
						        			<x-form-input name="lastname" label="{{ translate(651) }}" />
						        		</div>
						        	</div>
						        </div>

						        <div class="form-group">
						        	<div class="row">
						        		<div class="col-xs-12 col-lg-6 col-md-5">
						        			<x-form-phone-input label="{{ translate(191) }}" name="phone_number" />
						        		</div>
						        		<div class="col-lg-6 col-md-7">
						        			<x-form-input type="email" name="email" label="{{ translate(184) }}" />
						        		</div>
						        	</div>
						        </div>

						        <div class="form-group">
						        	<div class="row">
					        		<div class="col-12 col-md-4">
					        			<x-form-select name="gender" selectLabel="{{ translate(186) }}" :options=$genders optionValueKey="value" optionLabelKey="name" />
					        		</div>
					        		<div class="col-12 col-md-8">
					        			@php
					        				$oldBirthday = old('birthday');
					        				$birthdayParts = $oldBirthday ? explode('-', $oldBirthday) : [];
					        				$selectedYear = $birthdayParts[0] ?? '';
					        				$selectedMonth = isset($birthdayParts[1]) ? (int) $birthdayParts[1] : '';
					        				$selectedDay = isset($birthdayParts[2]) ? (int) $birthdayParts[2] : '';
					        				$maximumYear = now()->subYears(18)->year;
					        			@endphp
					        			<div class="form-group">
					        				<label class="form-label">{{ translate(187) }}</label>
					        				<div class="row no-gutters">
					        					<div class="col-3 pr-1">
					        						<select id="birthday_day" class="form-control @error('birthday') is-invalid @enderror" required aria-label="Jour">
					        							<option value="">JJ</option>
					        							@for ($day = 1; $day <= 31; $day++)
					        								<option value="{{ $day }}" {{ $selectedDay === $day ? 'selected' : '' }}>{{ str_pad($day, 2, '0', STR_PAD_LEFT) }}</option>
					        							@endfor
					        						</select>
					        					</div>
					        					<div class="col-5 px-1">
					        						<select id="birthday_month" class="form-control @error('birthday') is-invalid @enderror" required aria-label="Mois">
					        							<option value="">Mois</option>
					        							@for ($month = 1; $month <= 12; $month++)
					        								<option value="{{ $month }}" {{ $selectedMonth === $month ? 'selected' : '' }}>{{ str_pad($month, 2, '0', STR_PAD_LEFT) }}</option>
					        							@endfor
					        						</select>
					        					</div>
					        					<div class="col-4 pl-1">
					        						<select id="birthday_year" class="form-control @error('birthday') is-invalid @enderror" required aria-label="Année">
					        							<option value="">AAAA</option>
					        							@for ($year = $maximumYear; $year >= $maximumYear - 100; $year--)
					        								<option value="{{ $year }}" {{ (string) $selectedYear === (string) $year ? 'selected' : '' }}>{{ $year }}</option>
					        							@endfor
					        						</select>
					        					</div>
					        				</div>
					        				<input type="hidden" id="birthday" name="birthday" value="{{ $oldBirthday }}">
					        			</div>
					        		</div>
						        	</div>
						        </div>

						        <div class="form-group">
						        	<div class="row">
						        		<div class="col-lg-4">
						        			<x-form-select name="country_id" selectLabel="{{ translate(188) }}" :options=$countries optionValueKey="id" optionLabelKey="name" />
						        		</div>
						        		<div class="col-lg-4">
						        			<x-form-input name="city" label="{{ translate(189) }}" />
						        		</div>
						        		<div class="col-lg-4">
						        			<x-form-input name="address" label="{{ translate(190) }}" />
						        		</div>
						        	</div>
						        </div>
						    </div>

						    <div class="tab">
					        	<x-form-select name="account_type" selectLabel="{{ translate(192) }}" :options=$accountTypes optionValueKey="value" optionLabelKey="name" />
					        	<x-form-select 
					        		name="currency_id" 
					        		selectLabel="{{ translate(196) }}" 
					        		:options=$currencies 
					        		callback="currency_view_map" 
					        		optionValueKey="id" 
					        		optionLabelKey="name" />

					        	<div class="form-group">
					        		<label>{{ translate(831) }}</label>
					        		<p class="text-muted">{{ translate(833) }}</p>
					        		<select name="language_id" class="form-control input-lg" required>
					        			<option value=""></option>
					        		    @foreach ($languages as $lang)
					        		        <option value="{{ $lang->id }}" {{ ($lang->id == old('language_id')) ? " selected='selected'" : '' }}>{{ $lang->name }} ( {{ $lang->iso }} )</option>
					        		    @endforeach
					        		</select>
					        	</div>

					        	<div class="form-group">
					        		<div class="row">
					        			<div class="col-xs-12 col-md-6">
					        				<x-form-input type="password" name="password" label="{{ translate(653) }}" />
					        			</div>
					        			<div class="col-xs-12 col-md-6">
					        				<x-form-input type="password" name="password_confirmation" label="{{ translate(654) }}" />
					        			</div>
					        		</div>
					        	</div>

						        <x-recaptcha></x-recaptcha>
						    </div>

							<div class="d-flex mx-auto pt-4" id="process_box">
								<button type="button" id="prevBtn" class="btn btn-dark mr-4 d-none"><i class="fa fa-chevron-left"></i> {{ translate(404) }}</button>
								<button type="button" id="nextBtn" class="btn btn-dark mr-4 d-none">{{ translate(405) }} <i class="fa fa-chevron-right"></i></button>
								<button type="submit" id="submit-form" class="btn btn-lg btn-success d-none"><i class="fa fa-check"></i> {{ translate(197) }}</button>
							</div>

							<div class="pt-5">
								<p class="text-small">{{ translate(199) }}</p>
								<p class="text-small">{{ translate(200) }} : <a class="text-block mt-2" href="{{ routeWithLocale('guest.legal_notice') }}">{{ translate(201) }}.</a></p>
							</div>
						</form>
					</div>
				</div>
				<div class="col-lg-5 bg-with-covered-image" style="background-image: url({{ asset_img('default/pages/register__left.jpg') }});"></div>
			</div>
		</div>
	</section>

	<!-- partner area start -->
	<div class="partner-area bg-white">
	    <x-partners></x-partners>
	</div>
	<!-- partner area end -->
@endsection
