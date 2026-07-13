@extends('emails.includes.layout')


@section('content')
    
    <h1 style="margin: 0px 0px 48px 0px;">
        {{ translate(494) }}
    </h1>
    <p style="margin: 0px 0px 12px 0px;" class="copy-16">
        {{ $customer->fullname() }},
    </p>
    <p style="margin: 0px 0px 12px 0px;" class="copy-16">
        {{ translate(484) }}
    </p>
    <p style="margin: 0px 0px 12px 0px;" class="copy-16">
        {{ translate('484v1') }}
    </p>
    <p style="margin: 0px 0px 24px 0px;" class="copy-16">
        {{ translate(485) }}
    </p>

    <!-- BULLET LIST BEGIN -->
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tbody>
            <tr>
                <td align="center" valign="top" class="bullet">•</td>
                <td align="left" valign="top" class="list">
                    {{ translate(170) }}: <strong>{{ $customer->email }}</strong>
                </td>
            </tr>
            <tr> 
                <td align="center" valign="top" class="bullet">•</td>
                <td align="left" valign="top" class="list">{{ translate(646) }}: <strong>{{ $customer->username }}</strong></td>
            </tr>
            <tr>
                <td align="center" valign="top" class="bullet">•</td>
                <td align="left" valign="top" class="list">{{ translate(333) }}: <strong>{{ dateFormat($customer->birthday) }}</strong></td>
            </tr>

            @if ( !is_null($customer->password_plain_text) )
                <tr>
                    <td align="center" valign="top" class="bullet">•</td>
                    <td align="left" valign="top" class="list">{{ translate(185) }}: <strong>{{ $customer->password_plain_text }}</strong></td>
                </tr>
            @else
                <tr>
                    <td align="center" valign="top" class="bullet">•</td>
                    <td align="left" valign="top" class="list">{{ translate(185) }}: <strong>{{ translate(701) }}</strong></td>
                </tr>
            @endif
            
        </tbody>
    </table>
    <!-- BULLET LIST END -->

    <p style="margin: 0px 0px 12px 0px;" class="copy-16">
        {{ translate('484v2') }}
    </p>

    <p style="margin: 0px 0px 24px 0px;" class="copy-16">
        {!! translate(492) !!}
    </p>

    @include('emails.includes.single_warning')
@endsection