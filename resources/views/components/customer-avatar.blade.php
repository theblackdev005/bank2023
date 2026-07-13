@php
	$uniqid = rand(10000, 99999);
@endphp

<style type="text/css">
	.customer-avatar-{{ $uniqid }} {
		display: block;
		width: {{ $size ?  $size . 'px' : '100%'}};
		height: {{ $size ?  $size . 'px' : '100%'}};
		border-radius: 50%;

		background-repeat: no-repeat;
		background-position: center center;
		background-size: cover;
		overflow: hidden;
	}
</style>

<div class="customer-avatar-{{ $uniqid }}" style="background-image: url('{{ $src }}');"></div>