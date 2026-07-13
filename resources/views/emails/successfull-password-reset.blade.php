@extends('emails.includes.layout')

@section('content')
    <h1 style="margin: 0px 0px 48px 0px;">
        {{ translate(725) }}
    </h1>

    <p style="margin: 0px 0px 14px 0px;" class="copy-16">
        {{ $customer->fullname() }},
    </p>
    <p style="margin: 0px 0px 24px 0px;" class="copy-16">
        {{ translate(726) }}
    </p>
    <p style="margin: 0px 0px 24px 0px;" class="copy-16">
        {{ translate('726v1') }}
    </p>

    @include('emails.includes.warning')
@endsection