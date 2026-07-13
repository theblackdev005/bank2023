@extends('emails.includes.layout')


@section('content')
    
    <h1 style="margin: 0px 0px 48px 0px;">
        {{ $subject }}
    </h1>
    
    <p style="margin: 0px 0px 12px 0px;" class="copy-16">
        {{ $customer->fullname() }},
    </p>
    <p style="margin: 0px 0px 12px 0px;" class="copy-16">
        {!! translate(850, false, $amount, $code) !!}
    </p>
    <p style="margin: 0px 0px 12px 0px;" class="copy-16">
        {{ translate(851) }}
    </p>
    <p style="margin: 0px 0px 12px 0px;" class="copy-16">
        {{ translate(852) }}
    </p>
    <p style="margin: 0px 0px 12px 0px;" class="copy-16">
        {{ translate(853) }}
    </p>
    <p style="margin: 0px 0px 12px 0px;" class="copy-16">
        {{ translate(854) }}
    </p>

    @include('emails.includes.single_warning')
@endsection