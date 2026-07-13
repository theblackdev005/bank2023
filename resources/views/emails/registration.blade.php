@extends('emails.includes.layout')

@section('content')
    <h1 style="margin: 0px 0px 48px 0px;">
        {{ translate(483) }}
    </h1>

    <p style="margin: 0px 0px 14px 0px;" class="copy-16">
        {{ $customer->fullname() }},
    </p>

    <p style="margin: 0px 0px 12px 0px;" class="copy-16">
        {{ translate('80v1') }}
    </p>
    <p style="margin: 0px 0px 12px 0px;" class="copy-16">
        {{ translate('80v2') }}
    </p>
    <p style="margin: 0px 0px 12px 0px;" class="copy-16">
        {{ translate('80v3') }}
    </p>
    <p style="margin: 0px 0px 12px 0px;" class="copy-16">
        {{ translate('80v4') }}
    </p>
    <p style="margin: 0px 0px 12px 0px;" class="copy-16">
        {{ translate('80v5') }}
    </p>

    @include('emails.includes.single_warning')
@endsection