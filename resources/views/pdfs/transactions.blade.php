@extends('layouts.pdf')

@section('content')
	<table class="mb-3 100p">
	    <tr>
	        <td class="text-left" style="width: 33.33%;">
	            <h2 class="text-danger">{{ translate(408) }}</h2><br>
	            <p style="width:100%;"></p>
	            <p>{{ $totalDebit }}</p>
	        </td>
	        <td class="text-left" style="width: 33.33%;">
	            <h2 class="text-success">{{ translate(407) }}</h2><br>
	            <p style="width:100%;"></p>
	            <p>{{ $totalCredit }}</p>
	        </td>
	        <td class="text-left" style="width: 33.33%;">
	            <h2 class="text-warning">{{ translate(475) }}</h2><br>
	            <p style="width:100%;"></p>
	            <p>{{ $totalFacturation }}</p>
	        </td>
	    </tr>
	</table>

	<table class="mb-5">
	    <tr>
	        <td class="50p text-left">
	            <h4 class="mb-1">{{ SITE_NAME }}</h4>
	            <p>
	                {{ SITE_EMAIL }}<br>
	                {{ SITE_ADDRESS }}<br>
	            </p>
	        </td>
	        <td class="50p text-right">
	            <h4 class="mb-1">{{ $customer->fullname() }}</h4>
	            <p>
	                {{ $customer->email }}<br>
	                {{ $customer->address }}<br>
	            </p>
	        </td>
	    </tr>
	</table>

	<h3 class="title">{{ translate(395) }}</h3>
	<table class="border mb-3">
	   <thead class="thead">
	       <tr>
	           <th class="text-left">{{ translate(713) }}</th>
	           <th class="text-left">{{ translate(390) }}</th>
	           <th class="text-left">{{ translate(391) }}</th>
	           <th class="text-left">{{ translate(389) }}</th>
	           <th class="text-left">{{ translate(629) }}</th>
	       </tr>
	   </thead>
	   <tbody>

	   		@php
	   			extract($transactions);
	   		@endphp

	        @foreach ($data as $transaction_all)
	            @foreach ($transaction_all as $transaction)
	                <tr>
	                    <td class="text-left">
	                    	<strong>#{{ $transaction->uniqid }}</strong>
	                    </td>
	                    <td class="text-left text-{{ $transaction->type_html_clx }}">{{ translate($transaction->type_str) }}</td>
	                    <td class="text-left">
	                    	<strong>{{ setCurrency($DEFAULT_CURRENCY, $transaction->convert_cost) }}</strong>
	                    </td>
	                    <td class="text-left">{{ translate($transaction->description) }}</td>
	                    <td class="text-left">
	                    	<b>{{ dateFormat($transaction->created_at) }}</b><br>
	                    	{{ dateFormat($transaction->created_at, 2) }}
	                    </td>
	                </tr>
	            @endforeach
	        @endforeach

	       <tr>
	           <td class="no-border-full"></td>
	           <td class="no-border-full"></td>
	           <td class="no-border-full"></td>
	           <td class="no-border-full"></td>
	           <td class="no-border-full"></td>
	       </tr>
	   </tbody>
	</table>
@endsection