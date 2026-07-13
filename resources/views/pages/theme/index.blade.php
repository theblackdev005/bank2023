@extends('layouts.theme')

@php
	extract($component);
@endphp

@section('content')
	<div class="card shadow-sm my-5">
	    <div class="card-header bg-secondary">
	        <h3 class="text-white d-flex align-items-center m-0" style="line-height: 20px;">
	            <span class="badge d-inline-block badge-info">v{{ app()->version() }}</span>
	            <span class="d-inline-block ml-2">
	                <span>{{ ucfirst($title) }}</span><br>
	                <small class="font-weight-bold text-warning" style="font-size: 13px;">{{ $description }}</small>
	            </span>
	        </h3>
	    </div>

	    <div class="card-body">
	        <div class="wizard-container">

	            {{-- CONTENT --}}
	            @livewire('installation-wizard.' . $component)
	            {{-- CONTENT --}}

	        </div>
	    </div>

	    <div class="card-footer">
	        <div class="d-flex justify-content-between">

	        	@foreach ($links as $link => $data)
	        		<a href="{{ routeWithLocale('theme.index', $link) }}" class="btn btn-outline-dark font-weight-bold">
	        		    <i class="fa fa-check-circle"></i>
	        		    <span>{{ $data['title'] }}</span>
	        		</a>
	        	@endforeach

	            <a href="{{ routeWithLocale('guest.index') }}" class="btn ml-auto btn-warning font-weight-bold">
	                <i class="fa fa-check-circle"></i>
	                <span>Quitter</span>
	            </a>
	        </div>
	    </div>
	</div>
@endsection