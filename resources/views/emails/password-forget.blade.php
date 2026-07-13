@extends('emails.includes.layout')

@php
    $uri = routeWithLocale('guest.password_reset', compact('token', 'uid'));
@endphp

@section('content')
    <h1 style="margin: 0px 0px 48px 0px;">
        {{ translate(700) }}
    </h1>

    <p style="margin: 0px 0px 14px 0px;" class="copy-16">
        {{ $customer->fullname() }},
    </p>
    <p style="margin: 0px 0px 24px 0px;" class="copy-16">
        {{ translate(87) }}<br><br>
        {{ translate(699) }}
    </p>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tbody>
            <tr>
                <td data-ncid="code" align="center" bgcolor="{{ SITE_PRIMARY_COLOR}}" style="font-size: 24px; font-weight: 700; padding: 12px 12px 12px 12px; -webkit-border-radius: 5px; -moz-border-radius: 5px; border-radius: 5px;background: {{ SITE_PRIMARY_COLOR}};">
                    <a href="{{ $uri }}" style="-webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; text-decoration: none;color: #ffffff !important; font-size: 18px; font-weight: 700;">{{ translate(700) }}</a>
                </td>
            </tr>
        </tbody>
    </table><br><br>

    <p style="margin: 0px 0px 24px 0px;" class="copy-16">
        {{ translate(698) }} <a href="{{ $uri }}" class="link" style="-webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; text-decoration: none;">{{ $uri }}</a>.
    </p>

    @include('emails.includes.warning')
@endsection