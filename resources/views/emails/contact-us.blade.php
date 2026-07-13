@extends('emails.includes.layout')

@php
    extract($parameter['message'])
@endphp

@section('content')
    <h1 style="margin: 0px 0px 48px 0px;">
        {{ $subject }}
    </h1>

    <p style="margin: 18px 0px 6px 0px;" class="copy-18">Nom complet:</p>
    <p style="margin: 0px 0px 24px 0px;" class="copy-16">
        {{ $name }}
    </p>

    <p style="margin: 18px 0px 6px 0px;" class="copy-18">Email:</p>
    <p style="margin: 0px 0px 24px 0px;" class="copy-16">
        {{ $email }}
    </p>

    <p style="margin: 18px 0px 6px 0px;" class="copy-18">Message:</p>
    <p style="margin: 0px 0px 24px 0px;" class="copy-16">
        {!! nl2br($message) !!}
    </p>

    @if ( empty($hideCustomerInfo) )
        @include('emails.includes.customer-ip-ua')
    @endif
@endsection