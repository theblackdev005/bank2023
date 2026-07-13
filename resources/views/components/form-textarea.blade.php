@php
    $wireModel = $wiremodel ? 'wire:model='. $wiremodel : '';
@endphp

<div class="form-group">
    @if ( !empty($label) )
        <label for="" class="form-label">{{ $label }}</label>
    @endif
    <textarea {{ $wireModel }} placeholder="{{ $placeholder }}" rows="5" name="{{ $name }}" class="form-control @error($old) is-invalid @enderror">{{ old( $old ) ?? $value }}</textarea>
</div>