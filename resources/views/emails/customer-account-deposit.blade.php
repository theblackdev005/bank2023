@extends('emails.includes.layout')

@section('content')
    <h1 style="margin: 0px 0px 32px 0px;">
        {{ translate(1269) }}
    </h1>

    <p style="margin: 0px 0px 14px 0px;" class="copy-16">
        {{ str_replace(':name', $customer->fullname(), translate(1271)) }}
    </p>
    <p style="margin: 0px 0px 12px 0px;" class="copy-16">
        {{ translate(1272) }}
    </p>
    <p style="margin: 0px 0px 22px 0px;" class="copy-16">
        {{ translate(1280) }}
    </p>

    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin: 0px 0px 14px 0px; background: #f5f5f5;">
        <tbody>
            <tr>
                <td style="padding: 20px; text-align: center;">
                    <p style="margin: 0px 0px 6px 0px; font-size: 14px; line-height: 20px;">{{ rtrim(translate(1274), ':') }}</p>
                    <p style="margin: 0px; color: #4a4a4a; font-size: 28px; line-height: 36px; font-weight: 700;">{{ $amount }}</p>
                </td>
            </tr>
        </tbody>
    </table>

    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin: 0px 0px 24px 0px; border: 1px solid #e4e4e4;">
        <tbody>
            <tr>
                <td style="padding: 12px 16px; border-bottom: 1px solid #e4e4e4;" class="copy-16">{{ rtrim(translate(1277), ':') }}</td>
                <td style="padding: 12px 16px; border-bottom: 1px solid #e4e4e4; text-align: right;" class="copy-16"><strong>{{ $balanceAfter }}</strong></td>
            </tr>
            <tr>
                <td style="padding: 12px 16px; border-bottom: 1px solid #e4e4e4;" class="copy-16">{{ rtrim(translate(1276), ':') }}</td>
                <td style="padding: 12px 16px; border-bottom: 1px solid #e4e4e4; text-align: right;" class="copy-16"><strong>{{ $customer->username }}</strong></td>
            </tr>
            <tr>
                <td style="padding: 12px 16px; border-bottom: 1px solid #e4e4e4;" class="copy-16">{{ rtrim(translate(1278), ':') }}</td>
                <td style="padding: 12px 16px; border-bottom: 1px solid #e4e4e4; text-align: right;" class="copy-16"><strong>{{ dateFormat($transaction->created_at, 1, 'd/m/Y H:i', $timezone) }}</strong></td>
            </tr>
            <tr>
                <td style="padding: 12px 16px;" class="copy-16">{{ rtrim(translate(1279), ':') }}</td>
                <td style="padding: 12px 16px; text-align: right;" class="copy-16"><strong>{{ $transaction->uniqid }}</strong></td>
            </tr>
        </tbody>
    </table>

    <p style="margin: 0px 0px 16px 0px;" class="copy-16">{{ translate(1281) }}</p>
    <p style="margin: 0px 0px 24px 0px;">
        <a href="{{ routeWithLocale('customer.dashboard') }}" target="_blank" style="display: inline-block; padding: 12px 20px; background: {{ SITE_PRIMARY_COLOR }}; color: #ffffff !important; text-decoration: none; font-weight: 700;">
            {{ translate(1288) }}
        </a>
    </p>
    <p style="margin: 0px;" class="copy-16">{{ translate(1282) }}</p>
@endsection
