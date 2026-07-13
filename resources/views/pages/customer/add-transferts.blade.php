@extends('layouts.customer')

@section('content')
	
	@livewire('add-transfer-form', [
		'transfert_ref_msg' => $transfert_ref_msg,
	])

@endsection