@extends('emails.includes.layout')

@section('content')
    <h1 style="margin: 0px 0px 32px 0px;">
        {{ translate(725) }}
    </h1>

    <p style="margin: 0px 0px 14px 0px;" class="copy-16">
        {{ $customer->fullname() }},
    </p>
    <p style="margin: 0px 0px 22px 0px;" class="copy-16">
        {{ translate(726) }}
    </p>

    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin: 0px 0px 24px 0px; background: #f5f5f5;">
        <tbody>
            <tr>
                <td style="padding: 18px 20px;">
                    <p style="margin: 0px 0px 8px 0px;" class="copy-16">
                        <strong>{{ translate(183) }} :</strong> {{ $customer->username }}
                    </p>
                    <p style="margin: 0px;" class="copy-16">
                        <strong>{{ translate(185) }} :</strong> {{ $temporaryPassword }}
                    </p>
                </td>
            </tr>
        </tbody>
    </table>

    <p style="margin: 0px 0px 24px 0px;">
        <a href="{{ routeWithLocale('guest.login') }}" target="_blank" style="display: inline-block; padding: 12px 20px; background: {{ SITE_PRIMARY_COLOR }}; color: #ffffff !important; text-decoration: none; font-weight: 700;">
            {{ translate(150) }}
        </a>
    </p>

    @include('emails.includes.warning')
@endsection
