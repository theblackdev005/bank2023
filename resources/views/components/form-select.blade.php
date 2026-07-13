@php
    $wireModel = $wiremodel ? 'wire:model='. $wiremodel : '';
@endphp

<div class="form-group">
    @if ( !empty($selectLabel) )
        <label for="" class="form-label">{{ $selectLabel }}</label>
    @endif

    <select {{ $wireModel }} class="form-control @error($selectName) is-invalid @enderror" name="{{ $selectName }}" id="" required>
        <option value="">-</option>
        @foreach ($options as $option)
            @php
                $selectInner = !empty($optionLabelKey) ? $option[$optionLabelKey] : $option;
            @endphp
            <option {{ ($defaultValue == (!empty($optionValueKey) ? $option[$optionValueKey] : $option) ) ? 'selected="selected"' : null }} value="{{ !empty($optionValueKey) ? $option[$optionValueKey] : $option }}">{{ $callback ? $callback($option) : $selectInner }}</option>
        @endforeach
    </select>
</div>