@extends('layouts.pdf')

@section('content')
	<table class="mb-3">
	    <tr>
	        <td class="text-left">
	            <h1 class="text-theme">{{ translate(626) }}</h1><br>
	            <p style="width:100%;"></p>
	            <p>{!! sprintf(translate(506), "<strong class='text-success'>". setCurrency($transfert->currency, $transfert->amount) ."</strong>") !!}</p>
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

	<table class="mb-5">
	    <tr>
	        <td class="50p text-left">
	            <h4>{{ translate(629) }}</h4>
	            <p>{{ $transfert->created_at }}</p>
	        </td>
	        <td class="50p text-right text-success">
	            <h1 class="mb-1">{{ setCurrency($transfert->currency, $transfert->amount) }}</h1>
	        </td>
	    </tr>
	</table>

	<h3 class="title">{{ translate(503) }} ( <code class="text-theme">{{ dyn_recipient_translated_name($transfert->payment_method) }}</code> )</h3>
	<table class="border mb-3">
	   <thead class="thead">
	       <tr>
	           <th style="width: 49%" class="text-right">{{ translate(627) }}</th>
	           <th>></th>
	           <th style="width: 49%" class="text-left">{{ translate(630) }}</th>
	       </tr>
	   </thead>
	   <tbody>

	        @foreach (dyn_recipient_data($transfert) as $translation_key => $value)
	            <tr>
	                <td class="text-right">{{ translate($translation_key) }}</td>
	                <td>></td>
	                <td class="text-left">
	                    <strong class="text-theme">{{ $value }}</strong>
	                </td>
	            </tr>
	        @endforeach

	       <tr>
	           <td class="no-border-full"></td>
	           <td class="no-border-full"></td>
	           <td class="no-border-full"></td>
	       </tr>
	   </tbody>
	</table>

	<h3 class="title">{{ translate(628) }}</h3>
	<table class="border mb-3">
	   <thead class="thead">
	       <tr>
	           <th class="75p text-left">{{ translate(627) }}</th>
	           <th class="25p text-left">{{ translate(340) }} ({{ $customer->currency->name }})</th>
	       </tr>
	   </thead>
	   <tbody>
	       @php
	           $total = 0;
	       @endphp
	       
	       @foreach ($transfert->fees()->get() as $fee)
	           <tr>
	               <td>
	                   <p>{{ $fee->name }}</p>
	               </td>
	               <td>{{ setCurrency($fee->currency, $fee->cost) }}</td>
	           </tr>
	           @php
	               $total += $fee->cost;
	           @endphp
	       @endforeach
	       
	       <tr>
	           <td class="no-border-full"></td>
	           <td class="no-border-full">
	               <strong class="text-theme">{{ setCurrency($transfert->currency, $total) }}</strong>
	           </td>
	           <td class="no-border-full"></td>
	       </tr>
	   </tbody>
	</table>
@endsection