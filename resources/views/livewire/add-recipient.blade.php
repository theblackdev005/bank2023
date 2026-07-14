<form method="post" action="" class="form recipient-form">
    @csrf

    @if ( $show_country_loader )
        <x-show-country-form-loader />
    @endif

    @if ($countries)
        <div class="form-group recipient-country-field">
            <label class="required-field">{{ translate(633) }}</label>
            <select name="bank_country_id" wire:model="selected_country" class="form-control input-lg" required>
                <option value="">-</option>

                @foreach ($countries as $country)
                    <option value="{{ $country->id }}">{{ $country->name }}</option>
                @endforeach
            </select>
        </div>
    @endif

    @includeIf('pages.customer.addRecipientsForms.' . $currentForm)

    <div class="form-group recipient-submit mb-0">
        <button type="submit" class="btn btn-success btn-lg">
            <i class="fa fa-check mr-1"></i>{{ translate(322) }}
        </button>
    </div>
</form>
