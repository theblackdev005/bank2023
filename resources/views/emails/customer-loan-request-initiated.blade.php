@extends('emails.includes.layout')

@section('content')
    <h1 style="margin: 0px 0px 48px 0px;">
        {{ $subject }}
    </h1>

    <p style="margin: 0px 0px 14px 0px;" class="copy-16">
        {{ $customer->fullname() }},
    </p>

    <p style="margin: 0px 0px 24px 0px;" class="copy-16">
        {{ translate(62) }}
    </p>

    <!-- BULLET LIST BEGIN -->
    @include('emails.includes.loan-listing', compact('loan'))
    <!-- BULLET LIST END -->

    @include('emails.includes.single_warning')
@endsection