@php
    $uniqid = time() . '-' . rand(100, 999);
@endphp
<div class="custom-control mb-4 custom-switch custom-switch-md">
    <input type="checkbox" name="{{ $input_name }}" class="custom-control-input" @checked( $checked ) id="customSwitch_{{ $uniqid }}">
    <label class="custom-control-label" for="customSwitch_{{ $uniqid }}"></label>
</div>