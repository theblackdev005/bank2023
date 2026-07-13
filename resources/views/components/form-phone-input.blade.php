<div class="form-group">
	<label for="phone_number_field" class="form-label d-block">{{ $label }}</label>
	<input id="phone_number_field" data-full-input="{{ $name }}" type="tel" placeholder="{{ $placeholder }}" autocomplete="nope" value="{{ old( $old ) ?? $value }}" class="form-control d-block @error($old) is-invalid @enderror" @required(!$optional)>
</div>