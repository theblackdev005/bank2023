<div class="form-group">
    <label class="required-field">{{ translate(321) }}</label>
    <select class="form-control input-lg" name="currency_id" required>
        @foreach ($currencies as $currency)
            <option value="{{ $currency->id }}">{{ currency_view_map($currency) }}</option>
        @endforeach
    </select>
</div>