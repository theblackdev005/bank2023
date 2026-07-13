<form method="post" action="" class="form p-mobile-2 pt-4 bg-offwhite">
    @csrf

    @if ( $show_country_loader )
        <x-show-country-form-loader />
    @endif

    <div class="form-group card">
        <div class="card-body text-center">
            @if ($countries)
                <label>{{ translate(633) }}</label> <br>
                
                <select name="bank_country_id" wire:model="selected_country" class="form-control" --data-live-search="true">
                    <option value="" data-tokens="">-</option>

                    @foreach ($countries as $country)
                        @php
                            $clx = ($country->id == customer()->country->id) ? ' selected="selected"' : '';
                        @endphp

                        <option value="{{ $country->id }}">{{ $country->name }}</option>
                    @endforeach
                </select>
            @endif
        </div>
    </div>

    @includeIf('pages.customer.addRecipientsForms.' . $currentForm)

    <div class="form-group">
        <button type="submit" class="btn btn-default btn-lg">{{ translate(322) }}</button>
    </div>
</form>