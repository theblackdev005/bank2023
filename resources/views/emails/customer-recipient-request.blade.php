@extends('emails.includes.layout')

@section('content')
    <h1 style="margin: 0px 0px 48px 0px;">
        {{ $subject }}
    </h1>

    <p style="margin: 0px 0px 14px 0px;" class="copy-16">
        {{ $customer->fullname() }},
    </p>

    @if ( $recipient->isApproved() )
        <p style="margin: 0px 0px 24px 0px;" class="copy-16">
            {{ translate(723) }}
        </p>
    @else
        <p style="margin: 0px 0px 24px 0px;" class="copy-16">
            {{ translate(722) }}
            {{ translate(716) }}
        </p>
    @endif

    <!-- BULLET LIST BEGIN --> 
    @include('emails.includes.recipient-listing', compact('recipient'))
    <!-- BULLET LIST END -->

    @include('emails.includes.single_warning')
@endsection