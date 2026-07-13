@if ($countries)
    <label>{{ translate(633) }}</label>
    <select ng-model="countryIso" ng-change="setCountryIso(countryIso)" class="form-control height-auto input-lg selectpicker" data-live-search="true" style="height: auto !important">
        <option value="" data-tokens="">-</option>

        @foreach ($countries as $country)
            @php
                $clx = ($country->id == customer()->country->id) ? ' selected="selected"' : '';
            @endphp

            <option value="{{ $country->iso }}" data-tokens="{{ $country->iso }}" {{ $clx }}>{{ $country->name }}</option>
        @endforeach

    </select>
@endif